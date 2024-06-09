<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth;
use App\Models\Product;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;
use ReCaptcha\ReCaptcha;
use App\Observers\ProductData;
use App\Observers\ProductObserver;
use App\Observers\Subject;
use Illuminate\Support\Facades\URL;
use \DOMDocument;
use \XSLTProcessor;

class ProductController extends Controller
{
    // private $productObserver;

    // public function __construct(ProductObserver $productObserver)
    // {
    //     $this->productObserver = $productObserver;
    // }

    public function index()
    {
        $product = new ProductData();
        $observer = new ProductObserver($product);
        $product->attach($observer);
        $products = $product->retrieveAll();

        return view('user/all-product', compact('products'));
    }

    public function admin()
    {

        $product = new ProductData();
        $observer = new ProductObserver($product);
        $product->attach($observer);
        $products = $product->retrieveAll();

        return view('admin/all-product', compact('products'));
    }

    public function myCarsOnBid() 
    {
        $product = new ProductData();
        $observer = new ProductObserver($product);
        $product->attach($observer);
        $products = $product->findMyCars(auth()->user()->id);
        $productsOnBid = $product->findMyCarsOnBid(auth()->user()->id);

        $xml = new DOMDocument();
        $xml->load('../database/xml/sellers.xml');

        // Apply the XSLT transformation to the XML document
        $xsl = new DOMDocument();
        $xsl->load('../database/xsl/sellers.xsl');

        $proc = new XSLTProcessor();
        $proc->importStylesheet($xsl);
        $proc->setParameter('', 'seller_id', auth()->user()->id);

        $html = $proc->transformToXML($xml);

        return view('user/myCarsOnBid', compact('products', 'productsOnBid', 'html'));
    }

    public function details($id)
    {
        $product = new ProductData();
        $observer = new ProductObserver($product);
        $product->attach($observer);
        $product = $product->find($id);

        return view('user/product-details', compact('product'));
    }

    public function cart()
    {
        $product = new ProductData();
        $observer = new ProductObserver($product);
        $product->attach($observer);
        $orders = $product->findOrder(auth()->user()->id);

        return view('user/cart', compact('orders'));
    }

    public function addToCart($id)
    {
        if(!auth()->user()){
            $response = array('message' => 'no login');
            return json_encode($response);
        }

        $product = new ProductData();
        $observer = new ProductObserver($product);
        $product->attach($observer);
        $product = $product->find($id);
        if(auth()->user()-> id == $product->user_id){
            $response = array('message' => 'owner');
            return json_encode($response);
        }

        $data = [
            'user_id'       => auth()->user()->id,
            'product_id'    => $id
        ];
        $product = new ProductData();
        $observer = new ProductObserver($product);
        $product->attach($observer);
        if($product->addToCart($data)){
            $response = array('message' => 'success');
            return json_encode($response);
        }
        $response = array('message' => 'fail');
        return json_encode($response);
        
    }

    public function deleteCart($id)
    {
        $data = [
            'user_id'       => auth()->user()->id,
            'product_id'    => $id
        ];
        $product = new ProductData();
        $observer = new ProductObserver($product);
        $product->attach($observer);
        if($product->deleteCart($data)){
            $response = array('message' => 'success');
            return json_encode($response);
        }
        $response = array('message' => 'fail');
        return json_encode($response);
    }

    public function create()
    {
        return view('admin/add-product');
    }

    public function store(Request $request)
    {
        $request->validate([
            'make' => 'required',
            'model' => 'required',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'mileage' => 'required|numeric|min:0|max:999999',
            'color' => 'required',
            'transmission' => 'required',
            'pDesc' => 'required',
            'filepond' => 'required', // validate each image file in the array
            'price' => 'required|numeric',
            'g-recaptcha-response' => 'required|captcha'
        ]);

        $images = array();
        if ($files = $request->input('filepond')) {
            foreach ($files as $file) {
                $json_string = json_decode($file, true);
                $data_column = $json_string['data'];

                $image = base64_decode($data_column);
                $image_name = uniqid(rand(), false) . '.png';
                file_put_contents('../public/user/img/product/'.$image_name, $image);
                $images[] = $image_name;
            }
        }
        $product_image = implode("|", $images);

        $data = [
            'user_id'       => auth()->user()->id,
            'make'          => $request->input('make'),
            'model'         => $request->input('model'),
            'year'          => $request->input('year'),
            'mileage'       => $request->input('mileage'),
            'color'         => $request->input('color'),
            'transmission'  => $request->input('transmission'),
            'product_description'  => $request->input('pDesc'),
            'price'         => $request->input('price'),
            'product_image' => $product_image,
            'deleted'       => false,
        ];

        $product = new ProductData();
        $observer = new ProductObserver($product);
        $product->attach($observer);
        $product->storeAll($data);

        // if (auth()->user()->role == "admin" || auth()->user()->role == "staff") {
        //     return redirect()->route('products.admin')->with('success', 'Information has been added');
        // } else {
            return redirect()->route('products.index')->with('success', 'Information has been added');
        // }
    }

    public function edit($id)
    {
        $routeName = '';
        $previousUrl = URL::previous();
        $lastSegment = basename(parse_url($previousUrl, PHP_URL_PATH));

        $product = new ProductData();
        $observer = new ProductObserver($product);
        $product->attach($observer);
        $product = $product->find($id);

        if($lastSegment == "myCarsOnBid"){
            return view('user/edit-product', compact('product','lastSegment'));
        }
        return view('admin/edit-product', compact('product','lastSegment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request data
        $request->validate([
            'make' => 'required|string',
            'model' => 'required|string',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'mileage' => 'required|integer|min:0|max:999999',
            'color' => 'required|string',
            'transmission' => 'required|string',
            'pDesc' => 'required|string',
            'filepond' => 'required', // validate each image file in the array
            'price' => 'required|numeric|min:0',
        ]);

        $product = new ProductData();
        $observer = new ProductObserver($product);
        $product->attach($observer);
        $product = $product->find($id);

        //get the original product images from database
        $record_images = explode('|', $product->product_image);
        $array_record_images = array();
        foreach ($record_images as $image){
            $array_record_images[] = $image;
        }

        $images = array();
        $product_image;
        if ($files = $request->input('filepond')) {
            foreach ($files as $file) {
                $json_string = json_decode($file, true);
                $data_column = $json_string['data'];
                $filename = $json_string['name'];

                //check whether the uploaded images have the same images in database 
                if(!in_array($filename, $array_record_images)){
                    $image = base64_decode($data_column);
                    $image_name = uniqid(rand(), false) . '.png';
                    file_put_contents('../public/user/img/product/'.$image_name, $image);
                    $images[] = $image_name;
                } else {
                    $images[] = $filename;
                }
                
            }
            $product_image = implode("|", $images);
        }

        $data = [
            'id'            => $id,
            'make'          => $request->input('make'),
            'model'         => $request->input('model'),
            'year'          => $request->input('year'),
            'mileage'       => $request->input('mileage'),
            'color'         => $request->input('color'),
            'transmission'  => $request->input('transmission'),
            'product_description'  => $request->input('pDesc'),
            'price'         => $request->input('price'),
            'product_image' => $product_image,
        ];

        $product = new ProductData();
        $observer = new ProductObserver($product);
        $product->attach($observer);
        $product->updateAll($data);

        if($request->input('previousRouteName') == "myCarsOnBid"){
            return redirect('user/myCarsOnBid')->with('success', 'Product updated successfully.');
        }
        return redirect()->route('products.admin')->with('success', 'Product updated successfully.');
    }

    public function destroyProduct(Request $request, $id)
    {
        $routeName = '';
        $previousUrl = URL::previous();
        $lastSegment = basename(parse_url($previousUrl, PHP_URL_PATH));

        $product = new ProductData();
        $observer = new ProductObserver($product);
        $product->attach($observer);
        $product->delete($id);

        if($lastSegment == "myCarsOnBid"){
            return redirect('user/myCarsOnBid')->with('success', 'Product deleted successfully');
        }
        return redirect()->route('products.admin')->with('success', 'Product deleted successfully');
    }

    public function setDeleted($id)
    {
        $product = Product::find($id);

        $product->deleted = 1;
        $product->save();

        return response()->json(['message' => 'Product set deleted to 1 successfully'], 200);
    }

    public function setNoDeleted($id)
    {
        $product = Product::find($id);

        $product->deleted = 0;
        $product->save();

        return response()->json(['message' => 'Product set deleted to 0 successfully'], 200);
    }

}
