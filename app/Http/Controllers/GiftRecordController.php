<?php
namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Session;
use Illuminate\Http\Response;


class GiftRecordController extends Controller

{
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    
    public function index()
    {
        $giftRecords = $this->get();
        
         return view('admin/all-gift-record', [
            'giftRecords' => $giftRecords
        ]);
    }

    public function get()
    {
        $response = $this->client->request('GET', 'http://127.0.0.1:9000/api/gift-records');
        $giftRecords = json_decode($response->getBody()->getContents(), true);

        
        return $giftRecords;
    }

    public function create(){
        return view('admin/add-gift-record');
    }

    public function show($id)
    {
        $response = $this->client->request('GET', 'http://127.0.0.1:9000/api/gift-records/' . $id);
        $giftRecord = json_decode($response->getBody()->getContents(), true);
        if (!$giftRecord) {
            return null;
        }

        return response()->json($giftRecord);
    }
    public function store(Request $req){
        $iString = null;
        $req->validate([
            'paymentId' => [
                'required', 'integer', 'regex:/^.{0,255}$/','exists:payments,id', function ($attribute, $value, $fail) {
                    $response = $this->checkPaymentId($value);
                    if($response!=null){
                    $giftRecords = json_decode($response->getContent(), true);
                        if ($response->getStatusCode() == 200) {
                            $fail('The '.$attribute.' has already been used.');
                        }
                    }
                }
            ],
            'giftId' => ['string', 'regex:/^[0-9][0-9,]{0,254}$/',
            function ($attribute, $value, $fail) use (&$iString) {
                $freeGiftController = new FreeGiftController();
                $i = array();
                $giftIds = explode(',', $value);
                foreach ($giftIds as $index => $giftId) {
                    foreach ($giftIds as $prevIndex => $prevGiftId) {
                        if ($index !== $prevIndex && $giftId === $prevGiftId) {
                            $fail('The '.$attribute.' cannot contain duplicate giftIds.');
                        }
                    }
                    if($giftId){
                        $freeGifts = $freeGiftController->show(intval($giftId));
                        if($freeGifts){
                            $freeGiftsData = json_decode($freeGifts->getContent(), true);
                            if ($freeGiftsData['free_gift']['qty'] > 0 && $freeGiftsData['free_gift']['deleted'] == 0) {
                                //decrease free gift quantity
                                $freeGiftController->decrease($freeGiftsData['free_gift']['id']);
                                $i[] = $freeGiftsData['free_gift']['id']; 
                            }else{
                                $fail('The '.$attribute.' has not available');
                            }
                        }else{
                            $fail('The '.$attribute.' is invalid.');
                        }
                    }
                }
                $iString = implode(',', $i);
            }]
        ]);
        $data = [
            'paymentId' => $req->paymentId,
            'giftId' => $iString,
            'deleted' => 0
        ];
        
            $response = $this->client->post('http://127.0.0.1:9000/api/gift-records', [
                'json' => $data
            ]);
            $giftRecords = json_decode($response->getBody()->getContents(), true);
            return redirect('admin/gift-records')->with('success', 'Successfully added a gift record');
        
    }

    public function update($id,Request $req)
    {
        $iString = null;
        $old_giftId = $req->old_giftId;
        $req->validate([
            'paymentId' => [
                'required', 'integer', 'regex:/^.{0,255}$/','exists:payments,id', function ($attribute, $value, $fail)use ($id) {
                    $response = $this->checkPaymentId($value);
                    if($response!=null){
                    $giftRecords = json_decode($response->getContent(), true);
                        if($response->getStatusCode() == 200 && $giftRecords['gift_record']['id'] != $id){
                            $fail('The '.$attribute.' has already been used.');
                        }
                    }
                }
            ],
            'giftId' => ['string', 'regex:/^[0-9][0-9,]{0,254}$/',
            function ($attribute, $value, $fail) use (&$iString,$old_giftId) {
                $freeGiftController = new FreeGiftController();
                $i = array();
                $giftIds = explode(',', $value);
                $old_giftIds = explode(',', $old_giftId);
                foreach($old_giftIds as $old_giftId){
                    if($old_giftId){
                        $freeGifts = $freeGiftController->show(intval($old_giftId));
                        if($freeGifts){
                            $freeGiftsData = json_decode($freeGifts->getContent(), true);
                                //increase free gift quantity
                                $freeGiftController->increase($freeGiftsData['free_gift']['id']);
                        }
                    }
                }
                foreach ($giftIds as $index => $giftId) {
                    foreach ($giftIds as $prevIndex => $prevGiftId) {
                        if ($index !== $prevIndex && $giftId === $prevGiftId) {
                            $fail('The '.$attribute.' cannot contain duplicate giftIds.');
                        }
                    }
                    if($giftId){
                        $freeGifts = $freeGiftController->show(intval($giftId));
                        if($freeGifts){
                            $freeGiftsData = json_decode($freeGifts->getContent(), true);
                            if ($freeGiftsData['free_gift']['qty'] > 0 && $freeGiftsData['free_gift']['deleted'] == 0) {
                                //decrease free gift quantity
                                $freeGiftController->decrease($freeGiftsData['free_gift']['id']);
                                $i[] = $freeGiftsData['free_gift']['id']; 
                            }else{
                                $fail('The '.$attribute.' has not available');
                            }
                        }else{
                            $fail('The '.$attribute.' is invalid.');
                        }
                    }
                }
                $iString = implode(',', $i);
            }]
        ]);
        $data = [
            'paymentId' => $req->paymentId,
            'giftId' => $iString,
            'deleted' => 0
        ];
        
        $response = $this->client->put('http://127.0.0.1:9000/api/gift-records/'.$id, [
                    'json' => $data
                ]);
            $giftRecords = json_decode($response->getBody()->getContents(), true);
            return redirect('admin/gift-records')->with('success', 'Successfully edit a gift record');
    }


    public function destroyGiftRecord($id)
    {
        $response = $this->client->delete('http://127.0.0.1:9000/api/gift-records/'.$id);

        $giftRecords = json_decode($response->getBody()->getContents(), true);

        return redirect('admin/gift-records')->with('success', 'Successfully deleted a gift record');
    }

    public function edit($id)
    {
        $response = $this->show($id);
        $giftRecord = json_decode($response->getContent(), true)['gift_record'];
        return view('admin/edit-gift-record', compact('giftRecord'));
    }

    public function storeFromPayment(Request $req){
        $data = [
            'paymentId' => $req->paymentId,
            'giftId' => $req->giftId
        ];
            $response = $this->client->post('http://127.0.0.1:9000/api/gift-records', [
                'json' => $data
            ]);
            $giftRecords = json_decode($response->getBody()->getContents(), true);
            return response()->json(['message' => 'Gift Records stored successfully'], 200);
    }

    public function checkPaymentId($paymentId)
    {
        $response = $this->client->get('http://127.0.0.1:9000/api/gift-records/checkPaymentId/'.$paymentId);

        $giftRecords = json_decode($response->getBody()->getContents(), true);

        if ($giftRecords === null) {
            return null;
        }
        
        return response()->json($giftRecords);
    }

    public function updateFromPayment($id,Request $req)
    {
        $req->validate([
            'paymentId' => ['required', 'integer', 'regex:/^.{0,255}$/', 
                function ($attribute, $value, $fail) {
                    $response = $this->client->get('http://127.0.0.1:9000/api/gift-records/checkPaymentId/'.$value);
                    $giftRecords = json_decode($response->getBody()->getContents(), true);
                    if ($response->getStatusCode() == 404) {
                        $fail('The '.$attribute.' has already been used.');
                    }
                }
            ],
            'giftId' => ['string', 'regex:/^[0-9,]{0,255}$/'],
        ]);
        
    
            $data = [
                'paymentId' => $req->paymentId,
                'giftId' => $req->giftId
            ];
        $response = $this->client->put('http://127.0.0.1:9000/api/gift-records/'.$id, [
                    'json' => $data
                ]);
            $giftRecords = json_decode($response->getBody()->getContents(), true);
            return redirect('admin/gift-records')->with('success', 'Successfully edit a gift record');
    }
}