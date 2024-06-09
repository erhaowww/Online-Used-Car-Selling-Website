<?php

namespace App\Http\Controllers;
use DateTime;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Session;
use Illuminate\Foundation\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\FreeGiftController;
use App\Http\Controllers\GiftRecordController;
use App\Http\Controllers\ProductController;
use App\Builders\PaymentBuilder;
use App\Builders\PaymentQueryBuilder;
use App\Models\Payment;
use App\Models\Order;
use App\Models\Product;
use GuzzleHttp\Client;
use \DOMDocument;
use \XSLTProcessor;

class PaymentController extends Controller
{
    protected $paymentBuilder;
    private $client;

    public function __construct(PaymentBuilder $paymentBuilder)
    {
        $this->paymentBuilder = $paymentBuilder;
        $this->client = new Client();
    }

    public function index()
    {
        $payments = $this->paymentBuilder->readAll();

        return view('admin/all-payment', compact('payments'));
    }

    public function edit($id)
    {
        $payment = $this->paymentBuilder->readById($id);

        $date = new DateTime();
        $payment->payment_date = $date->format('Y-m-d');

        return view('admin/edit-payment', compact('payment'));
    }
    
    public function create(){
        return view('admin/add-payment');
    }
    public function store(Request $req){
        $req->validate([
            'order_id' => [
                'required', 'string', 'regex:/^[0-9][0-9,]{0,254}$/',
                function ($attribute, $value, $fail) use (&$iString) {
                    $i = array();
                    $order_ids = explode(',', $value);
                    $user_id = null;
                    foreach ($order_ids as $index => $order_id) {
                        $exists = DB::table('orders')
                            ->where('id', $order_id)
                            ->where('status', 'available')
                            ->exists();
                        if (!$exists) {
                            $fail("The {$attribute} must contain valid order IDs with a status of 'available'.");
                            return;
                        }
                        $order = DB::table('orders')
                            ->select('user_id')
                            ->where('id', $order_id)
                            ->first();
                        $order_user_id = $order->user_id;
                        if ($index === 0) {
                            $user_id = $order_user_id;
                        } else {
                            if ($user_id !== $order_user_id) {
                                $fail('The user ID of order ID is different.');
                                return;
                            }
                        }
                        $i[] = $order_id;
                    }
                    $iString = implode(',', $i);
                },
            ],            
            'total_charge' => 'required|int|regex:/^[0-9]{0,10}$/',
            'date' => 'required|date',
            'method' => 'required',
            'address' => 'required|string'
        ]);
        
        $date_string = $req->input('date');
        $payment_date = DateTime::createFromFormat('Y-m-d', $date_string);
        $data = [
            'order_id' => $iString,
            'total_charge' => $req->total_charge,
            'payment_date' => $payment_date,
            'payment_method' => $req->method,
            'billing_address' => $req->address,
            'deleted' => 0
        ];
        $payment = $this->paymentBuilder->create($data);
        $paymentId = $payment->id;

        $freeGiftController = new FreeGiftController();
        $freeGifts = $freeGiftController->get();
        $giftIds = array();
        foreach ($freeGifts['freeGifts'] as $item) {
            if (intval($item['giftRequiredPrice']) <= $req->total_charge && $item['qty'] > 0 && $item['deleted'] == 0) {
                //decrease free gift quantity
                $freeGiftController->decrease($item['id']);
                $giftIds[] = $item['id']; 
            }
        }
        $giftIdsString = implode(',', $giftIds);
        $i = array();
        if($giftIdsString){
            //update giftRecord
            $giftRecordController = new GiftRecordController();
            $recordData = new Request([
                'paymentId' => $paymentId,
                'giftId' => $giftIdsString,
            ]);
            $giftRecordController->storeFromPayment($recordData);
        }

        //update order status to Paid
        $order_id_array = explode(',', $iString);

        foreach ($order_id_array  as $order_ids) {
            $order = Order::find($order_ids);
        if ($order && $order->status === 'available') {
            $order->status = 'paid';
            $order->save();
        }
        $product_id = $order->product_id;

        $orders = Order::where('product_id', $product_id)->get();

        //update order status same product id to Sold
        foreach ($orders as $order) {
            if ($order->status === 'available') {
                $order->status = 'sold';
                $order->save();
            }
        }
        //set product deleted to 1
        $productController = new ProductController();
        $products = $productController->setDeleted($product_id);
        }

        

        return redirect('admin/payments')->with('success', 'Successfully added a payment');

    }

    public function update(Request $req, $id)
    {
        $allIString = $req->order_id;
        $previousIString = $req->old_order_id;
        $previousArray = explode(",", $previousIString);
        if($allIString == ''){
            $allIString = $previousIString;
        }


        $newArray = explode(",", $allIString);

        $missingIds = array_diff($previousArray, $newArray);

        if($req->old_order_id==$req->order_id){
            $req->validate([
                'order_id' => [
                'required',
                'string',
                'regex:/^[0-9][0-9,]{0,254}$/'
            ]]);
        }else{
            $req->validate([
                'order_id' => [
                    'required', 'string', 'regex:/^[0-9][0-9,]{0,254}$/',
                    function ($attribute, $value, $fail) use (&$newIString,&$oldIString, $req) {
                        $i = array();
                        $j = array();
                        $order_ids = explode(',', $value);
                        $old_order_id = $req->old_order_id;
                        $old_order_ids = explode(',', $old_order_id);
                        $user_id = null;
                        foreach ($order_ids as $index => $order_id) {
                            
                            foreach ($order_ids as $prevIndex => $prevOrderId) {
                                if ($index !== $prevIndex && $order_id === $prevOrderId) {
                                    $fail('The '.$attribute.' cannot contain duplicate order id.');
                                    return;
                                }
                            }

                            $order = DB::table('orders')
                            ->select('user_id')
                            ->where('id', $order_id)
                            ->first();
                            $order_user_id = $order->user_id;
                            
                            if ($index === 0) {
                                $user_id = $order_user_id;
                            } else {
                                if ($user_id !== $order_user_id) {
                                    $fail('The user ID of order ID is different.');
                                    return;
                                }
                            }

                            if ($order_id) {
                                $order = DB::table('orders')->where('id', $order_id)->first();
                                if (!$order || !in_array($order->status, ['available', 'paid'])) {
                                    $fail("The {$attribute} must contain valid order IDs with a status of 'available' or 'paid'.");
                                    return;
                                }
                                
                                if ($order->status == 'paid') {
                                    foreach ($old_order_ids as $old_order_id) {
                                        if ($order_id == $old_order_id && $order->status == 'paid') {
                                            $i[] = $order_id;
                                            break; // exit the loop once a match is found
                                        }
                                    }
                                } else if ($order->status == 'available') {
                                    $j[] = $order_id;
                                } else {
                                    $fail("The {$attribute} must contain valid order IDs.");
                                    return;
                                }
                            }
                        }
                        $oldIString = implode(',', $i);
                        $newIString = implode(',', $j);
                    },
                ]
            ]);
        }
        
        $req->validate([
            'total_charge' => 'required|int|regex:/^[0-9]{0,10}$/',
            'date' => 'required|date',
            'method' => 'required',
            'address' => 'required|string'
        ]);

        $date_string = $req->input('date');
        $payment_date = DateTime::createFromFormat('Y-m-d', $date_string);
        $data = [
            'order_id' => $allIString,
            'total_charge' => $req->total_charge,
            'payment_date' => $payment_date,
            'payment_method' => $req->method,
            'billing_address' => $req->address,
            'deleted' => 0
        ];

        $payment = $this->paymentBuilder->update($id,$data);
        $paymentId = $payment->id;

        $freeGiftController = new FreeGiftController();
        $freeGifts = $freeGiftController->get();
        $giftIds = array();
        foreach ($freeGifts['freeGifts'] as $item) {
            if (intval($item['giftRequiredPrice']) <= $req->total_charge && $item['qty'] > 0 && $item['deleted'] == 0) {
                //decrease free gift quantity
                $freeGiftController->decrease($item['id']);
                $giftIds[] = $item['id']; 
            }
        }
        $giftIdsString = implode(',', $giftIds);
        //update giftRecord
        $giftRecordController = new GiftRecordController();
        $giftRecordResponse = $giftRecordController->checkPaymentId($paymentId);
        $recordData = new Request([
            'paymentId' => $paymentId,
            'giftId' => $giftIdsString,
        ]);
        
        //increase the gift that have in gift record
        if($giftRecordResponse){
            $giftRecord = json_decode($giftRecordResponse->getContent())->gift_record;
            $giftRecordId = $giftRecord->id;
            $ids = $giftRecord->giftId;
            $idsStrings = explode(',', $ids);
            foreach ($idsStrings as $idsString) {
                $freeGiftController->increase($idsString);
              }

            $giftRecordController->updateFromPayment($giftRecordId,$recordData);
        }else{
            $giftRecordController->storeFromPayment($recordData);
        }

        if($allIString != $req->old_order_id){

            //update old order status change to unused
            foreach ($missingIds as $missingId) {
                $old_order = Order::find($missingId);
                if ($old_order && $old_order->status === 'paid') {
                    $old_order->status = 'available';
                    $old_order->save();
            
                    // find sold orders for the same product and update status to available
                    $product_id = $old_order->product_id;
                    $sold_orders = Order::where('product_id', $product_id)
                                        ->where('status', 'sold')
                                        ->get();
                    foreach ($sold_orders as $sold_order) {
                        $sold_order->status = 'available';
                        $sold_order->save();
                    }
                    $productController = new ProductController();
                    $old_products = $productController->setNoDeleted($product_id);
                }
                
            }
            
            //update order status to Paid
            $order_ids = explode(',', $newIString);
            foreach ($order_ids as $order_id) {
                $order = Order::find($order_id);
                if ($order && $order->status === 'available') {
                    $order->update(['status' => 'paid']);
                }
                $product_id = $order->product_id;
                $orders = Order::where('product_id', $product_id)->get();
                //update order status same product id to Sold
                foreach ($orders as $order) {
                    if ($order->status === 'available') {
                        $order->status = 'sold';
                        $order->save();
                    }
                }
                //set product deleted to 1
                $productController = new ProductController();
                $products = $productController->setDeleted($product_id);
            }

            
            
        }

        return redirect('admin/payments')->with('success', 'Payment information has been updated');

    }

    public function destroyPayment($id)
    {
        $this->paymentBuilder->delete($id);

        return redirect('admin/payments')->with('success', 'Payment information has been deleted');
    }

    public function displayPayment($selectedOrderIds)
    {

        $user_id = Session::get('user')['id'];

        $freeGiftController = new FreeGiftController();
        $freeGifts = $freeGiftController->get();
        $orderId = explode(',', base64_decode($selectedOrderIds));
        
        $productDetail;
        if(count($orderId) == 1) {
            $productDetail = DB::table('users')
                            ->where('users.id' , $user_id)
                            ->join('orders','orders.user_id','=','users.id')
                            ->join('products','products.id','=','orders.product_id')
                            ->where('orders.id',$orderId[0])
                            ->where('orders.status','available')
                            ->where('orders.deleted',0)
                            ->where('products.deleted',0)
                            ->select('*', 'orders.id AS order_id')
                            ->get();
        } else {
            $productDetail = DB::table('users')
                            ->where('users.id' , $user_id)
                            ->join('orders','orders.user_id','=','users.id')
                            ->join('products','products.id','=','orders.product_id')
                            ->whereIn('orders.id',$orderId)
                            ->where('orders.status','available')
                            ->where('orders.deleted',0)
                            ->where('products.deleted',0)
                            ->select('*', 'orders.id AS order_id')
                            ->get();
        }

        $totalPrice = 0;
        foreach($productDetail as $product){
            $totalPrice += $product->price;
        }

        //check whether user has membershp
        // Load the existing customers XML file
        $customersXml = simplexml_load_file('../database/xml/customers.xml');
        // Find the customer element for the current user
        $customerXml = $customersXml->xpath("/customers/customer[@id='$user_id']");
        // Check if the customer already has a membership
        $membership = [];
        if (!empty($customerXml)) {
            $membership['level'] = $customerXml[0]->{'membership-level'};
            $membership['discount'] = $customerXml[0]->discount;
            $membership['discountPrice'] = $totalPrice * ($membership['discount'] / 100);;
        }
        
        $count=0;
        $freeGiftName="";
        foreach ($freeGifts['freeGifts'] as $item) {
            if (intval($item['giftRequiredPrice']) <= $totalPrice && $item['qty'] > 0 && $item['deleted'] == 0) {
                $count++;
                $freeGiftName .= $item['giftName'];
                $freeGiftName .= ',';
            }
        }
        $gift = rtrim($freeGiftName, ",");
        

        $tax = $totalPrice * 0.1;
                    $shippingMethods = [
                        [
                            'id' => 'gls',
                            'name' => 'GLS',
                            'desc' => 'GLS - Package delivered directly to the door',
                            'price' => '200',
                            'type' => 'private'
                        ],
                        [
                            'id' => 'fedex',
                            'name' => 'FedEx',
                            'desc' => 'FedEx - Package delivered directly to the door',
                            'price' => '250',
                            'type' => 'private'
                        ],
                        [
                            'id' => 'dhl',
                            'name' => 'DHL',
                            'desc' => 'DHL - Package delivered directly to the door',
                            'price' => '400',
                            'type' => 'company'
                        ]
                    ];
                    return view('user/payment', [
                        'shippingMethods' => $shippingMethods,
                        'productDetail' => $productDetail,
                        'totalPrice' => $totalPrice,
                        'tax' => $tax,
                        'gift' => $gift,
                        'count'=>$count,
                        'orderId'=>base64_decode($selectedOrderIds),
                        'membership'=>$membership
                    ]);
    }

    public function createPayment(Request $req)
    {
        $req->validate([
            'name' => 'required|string|regex:/^[a-zA-Z\s]*$/',
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    $user = auth()->user();
                    if (!$user || $user->email !== $value) {
                        $fail('The email address does not belong to the currently authenticated user.');
                    }
                },
            ],
            'address' => 'required|string',
            'country' => 'required',
            'state' => 'required',
            'zip' => 'required|string|regex:/^[0-9]{5}$/',
            'shippingMethod' => 'required',
            'paymentMethod' => 'required',
            'cc-name' => 'required|string|regex:/^[a-zA-Z\s]*$/',
            'cc-number' => 'required|string|regex:/^[0-9]{16}$/',
            'cc-expiration' => [
                'required',
                'string', 
                'regex:/^(0[1-9]|1[0-2])\/[0-9]{2}$/',
            ],
            'cc-cvv' => 'required|string|regex:/^[0-9]{3}$/'
            
        ]);

        $queryBuilder = new PaymentQueryBuilder();
        $builder = new PaymentBuilder($queryBuilder);

        $payment = $builder
            ->create([
                'order_id' => $req->input('order_id_hidden'),
                'total_charge' => $req->input('grand_total_hidden'),
                'payment_date' => now()->format('Y-m-d H:i:s'),
                'payment_method' => $req->paymentMethod,
                'billing_address' => $req->address . ', ' . $req->zip . ' ' . $req->state . ', ' . $req->country,
                'deleted' => 0
            ]);
            $paymentId = $payment->id;

            $freeGiftController = new FreeGiftController();
            $freeGifts = $freeGiftController->get();
            $giftIds = array();
            foreach ($freeGifts['freeGifts'] as $item) {
                if (intval($item['giftRequiredPrice']) <= $req->product_price && $item['qty'] > 0 && $item['deleted'] == 0) {
                    
                    $freeGiftController->decrease($item['id']);
                    $giftIds[] = $item['id']; 
                }
            }
            $giftIdsString = implode(',', $giftIds);
            if($giftIdsString){
                //update giftRecord
                $giftRecordController = new GiftRecordController();
                $recordData = new Request([
                    'paymentId' => $paymentId,
                    'giftId' => $giftIdsString,
                ]);
                $giftRecordController->storeFromPayment($recordData);
            }
            //update order status to Paid
            $orderId = explode(',', $req->order_id_hidden);
            $order;
            if (count($orderId) > 1) {
                // $orderId has more than one element
                // Handle the multiple order IDs here
                foreach ($orderId as $id) {
                    $order = Order::find($id);
                    if ($order && $order->status === 'available') {
                        $order->status = 'paid';
                        $order->save();
                    }
                    $product_id = $order->product_id;
                    $orders = Order::where('product_id', $product_id)->get();
                    //update order status same product id to Sold
                    foreach ($orders as $order) {
                        if ($order->status === 'available') {
                            $order->status = 'sold';
                            $order->save();
                        }
                    }
                    //set product deleted to 1
                    $productController = new ProductController();
                    $products = $productController->setDeleted($product_id);
                }
            } else {
                // $orderId has only one element
                // Proceed with updating the single order status here
                $order = Order::find($orderId)->first();
                if ($order && $order->status === 'available') {
                    $order->status = 'paid';
                    $order->save();
                }
                $product_id = $order->product_id;
                $orders = Order::where('product_id', $product_id)->get();
        
                //update order status same product id to Sold
                foreach ($orders as $order) {
                    if ($order->status === 'available') {
                        $order->status = 'sold';
                        $order->save();
                    }
                }
                //set product deleted to 1
                $productController = new ProductController();
                $products = $productController->setDeleted($product_id);
            }

            // Load the existing sellers XML file
            $sellersXml = simplexml_load_file('../database/xml/sellers.xml');

            $order_ids = explode(',', $payment->order_id);
            foreach ($order_ids as $order_id) {
                $order = Order::where('id', $order_id)->first();
                if ($order) {
                    $product = Product::where('id', $order->product_id)->first();
                    if ($product) {
                        // Create a new seller element
                        $newSeller = $sellersXml->addChild('seller');
                        $newSeller->addChild('seller_id', $product->user_id);

                        // Create a new car element
                        $newCar = $newSeller->addChild('car');
                        $newCar->addChild('make', $product->make);
                        $newCar->addChild('model', $product->model);
                        $newCar->addChild('year', $product->year);
                        $newCar->addChild('mileage', $product->mileage);
                        $newCar->addChild('color', $product->color);
                        $newCar->addChild('transmission', $product->transmission);
                        $newCar->addChild('description', $product->product_description);
                        $image_array = explode('|', $product->product_image);
                        $newCar->addChild('image', $image_array[0]);
                        $newCar->addChild('price', $product->price);

                        // Create a new buyer element
                        $newBuyer = $newCar->addChild('buyer');
                        $newBuyer->addChild('name', auth()->user()->name);
                        $newBuyer->addChild('email', auth()->user()->email);

                        // Save the updated XML file
                        $sellersXml->asXML('../database/xml/sellers.xml');
                    }
                }
            }

            // Load the existing delivery XML file
            $deliveryXml = simplexml_load_file('../database/xml/delivery.xml');
            // Create a new delivery record as a car element
            $newDelivery = $deliveryXml->addChild('car');
            $newDelivery->addChild('payment_id', $payment->id);
            $newDelivery->addChild('delivery_date', date("Y-m-d"));
            $newDelivery->addChild('delivery_status', 'Prepare to Ship');
            // Save the updated XML file
            $deliveryXml->asXML('../database/xml/delivery.xml');

        return redirect('user/payment-history')->with('success', 'Payment successful! Thank you for your purchase.');
    }

    public function displayPaymentHistory()
    {

        $user_id = Session::get('user')['id'];

        $response = $this->client->request('GET', 'http://127.0.0.1:9000/api/memberships');
        $memberships = json_decode($response->getBody()->getContents(), true);

        $productDetailQuery = DB::table('users')
                        ->where('users.id' , $user_id)
                        ->join('orders','orders.user_id','=','users.id')
                        ->join('products','products.id','=','orders.product_id')
                        ->where('orders.status','paid')
                        ->where('orders.deleted',0)
                        ->where('products.deleted',1)
                        ->select('*', 'orders.id AS order_id');

        $productDetail = $productDetailQuery->get();

        $comments = DB::table('comments')
                ->where('deleted' , 0)
                ->get();
        
        $totalSpent = 0;
        $name = '';
        $email = '';
        $phoneNum = '';
        $previousPaymentId = '';
        $payments = [];
        $count = 0;
        foreach($productDetail as $customer){
            $payment = DB::table('payments')
            ->whereRaw("FIND_IN_SET(?, payments.order_id)", [$customer->order_id])
            ->get();
            if($payment[0]->id != $previousPaymentId){
                $totalSpent += $payment[0]->total_charge;
                $count += 1; 
            }
            $payment[0]->delivery_status = '';
            $payments[] = $payment[0];
            $previousPaymentId = $payment[0]->id;
            $name = $customer->name;
            $email = $customer->email;
            $phoneNum = $customer->phoneNum;
        }

        // Load the delivery XML file into a SimpleXMLElement object
        $xml = simplexml_load_file('../database/xml/delivery.xml');

        foreach ($xml->car as $car) {
            $paymentId = (string) $car->payment_id;
            $deliveryStatus = (string) $car->delivery_status;
            
            // Find the payment with the matching ID in the $payments array
            foreach ($payments as $payment) {
                if ($payment->id == $paymentId) {
                    $payment->delivery_status = $deliveryStatus;
                    break;
                }
            }
        }

        // Load the existing customers XML file
        $customersXml = simplexml_load_file('../database/xml/customers.xml');

        // Find the customer element for the current user
        $customerXml = $customersXml->xpath("/customers/customer[@id='$user_id']");

        // Check if the customer already has a membership
        if (!empty($customerXml)) {
            $currentMembershipLevel = $customerXml[0]->{'membership-level'};
            $currentMembershipDiscount = (float) $customerXml[0]->discount;

            // Find the next membership level and discount
            $nextMembershipLevel = '';
            $nextMembershipDiscount = 0;
            foreach ($memberships['memberships'] as $membership) {
                if ($membership['level'] == $currentMembershipLevel) {
                    continue;
                }
                if ($totalSpent >= $membership['totalAmount_spent']) {
                    $nextMembershipLevel = $membership['level'];
                    $nextMembershipDiscount = $membership['discount'];
                    break;
                } 
            }

            // Check if the user's total spent qualifies for an upgrade
            if ($nextMembershipLevel != '' && $nextMembershipDiscount > $currentMembershipDiscount) {
                $customerXml[0]->{'membership-level'} = $nextMembershipLevel;
                $customerXml[0]->discount = $nextMembershipDiscount;
                // Save the updated XML file
                $customersXml->asXML('../database/xml/customers.xml');

                // Add a flash message
                Session::flash('membership_upgrade_message', 'Congratulations, you have been upgraded to '.$nextMembershipLevel.' membership level!');
            }
        } else {
            // Determine the membership level based on the total spent
            $membershipLevel = '';
            $membershipDiscount = 0;
            foreach ($memberships['memberships'] as $membership) {
                if ($totalSpent >= $membership['totalAmount_spent']) {
                    $membershipLevel = $membership['level'];
                    $membershipDiscount = $membership['discount'];
                    break;
                } 
            }

            if(!empty($membershipLevel)){
                // Create a new customer element for the current user
                $newCustomer = $customersXml->addChild('customer');
                $newCustomer->addAttribute('id', $user_id);
                $newCustomer->addChild('name', $name);
                $newCustomer->addChild('email', $email);
                $newCustomer->addChild('phone', $phoneNum);
                $newCustomer->addChild('total-spent', $totalSpent);
                $newCustomer->addChild('membership-level', $membershipLevel);
                $newCustomer->addChild('discount', $membershipDiscount);
                
                // Save the updated XML file
                $customersXml->asXML('../database/xml/customers.xml');

                // Add a flash message
                Session::flash('membership_upgrade_message', 'Congratulations, you have been awarded '.$membershipLevel.' membership level!');
            }

        }

        return view('user/payment-history', [
            'productDetail' => $productDetail,
            'count'=>$count,
            'payments' => $payments,
            'comments' => $comments
        ]);
    }

    public function verify_card_info(Request $req)
    {
        $response = $this->client->request('GET', 'http://127.0.0.1:9000/api/card_info');
        $card_infos = json_decode($response->getBody()->getContents(), true);
        foreach ($card_infos['card_infos'] as $card_info) {
            if($card_info['card_number'] == $req->post('number') && $card_info['expiration_date'] == $req->post('expDate') && $card_info['cardholder_name'] == $req->post('name') && $card_info['cvv'] == $req->post('cvv') && $card_info['payment_method'] == $req->post('payMethod'))
            {
                $response = array('message' => true);
                return json_encode($response);
            }
        }
        $response = array('message' => false);
        return json_encode($response);
    }

    public function delivery()
    {
        $xml = new DOMDocument();
        $xml->load('../database/xml/delivery.xml');

        // Apply the XSLT transformation to the XML document
        $xsl = new DOMDocument();
        $xsl->load('../database/xsl/delivery.xsl');

        $proc = new XSLTProcessor();
        $proc->importStylesheet($xsl);
        $html = $proc->transformToXML($xml);

        return view('admin/delivery', compact('html'));
    }

    public function edit_delivery($id)
    {
        $xml = new DOMDocument();
        $xml->load('../database/xml/delivery.xml');

        // Apply the XSLT transformation to the XML document
        $xsl = new DOMDocument();
        $xsl->load('../database/xsl/edit-delivery.xsl');

        $proc = new XSLTProcessor();
        $proc->importStylesheet($xsl);
        $proc->setParameter('', 'payment_id', $id);

        $html = $proc->transformToXML($xml);

        return view('admin/edit-delivery', compact('html', 'id'));
    }

    public function update_delivery(Request $request, $id)
    {
        $deliveryXml = simplexml_load_file('../database/xml/delivery.xml');
        $delivery = $deliveryXml->xpath("//car[payment_id='$id']");
        if (!empty($delivery)) {
            $delivery[0]->delivery_status = $request->delivery_status;
            $deliveryXml->asXML('../database/xml/delivery.xml');
            return redirect('admin/delivery')->with('success', 'Delivery status updated successfully');
        }
        
        return redirect('admin/delivery')->with('failed', 'Delivery status updated failed');
    }

    public function monthlySales_report()
    {
        $monthlySales = Payment::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") AS month'), DB::raw('SUM(total_charge) AS total_sales'))
                  ->groupBy('month')
                  ->orderBy('month', 'ASC')
                  ->get();

        // Initialize sales array
        $salesArray = array_fill(0, 12, 0); // fill with 0 for all 12 months
        
        // Update sales array with monthly sales data
        foreach ($monthlySales as $sale) {
            $monthIndex = intval(substr($sale->month, 5)) - 1; // get month index (0-11) from date string
            $salesArray[$monthIndex] = $sale->total_sales;
        }
        
        return view('admin/report-monthlySales', compact('salesArray'));
    }
}
