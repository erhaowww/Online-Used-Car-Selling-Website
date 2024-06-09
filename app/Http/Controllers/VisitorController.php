<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\UserSystemInfoHelper;
use GuzzleHttp\Client;
use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\VisitorRepositoryInterface;


class VisitorController extends Controller
{
    private $visitorRepository;

    public function __construct(VisitorRepositoryInterface $visitorRepository)
    {
        $this->visitorRepository = $visitorRepository;
        $this->client = new Client();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $response = $this->client->get('https://api.ipify.org');
        $ipAddress = $response->getBody()->getContents();
        $output = geoip()->getLocation($ipAddress);
        $current_location = array(
            'iso_code'		=>	$output->iso_code,
            'country'	    =>	$output->country,
            'city'	        =>	$output->city,
            'state'	        =>	$output->state,
            'state_name'	=>	$output->state_name,
            'postal_code'	=>	$output->postal_code,
            'lat'		    =>	$output->lat,
            'lon'		    =>	$output->lon,
            'timezone'		=>	$output->timezone,
            'continent'		=>	$output->continent,
            'currency'		=>	$output->currency,
            'default'		=>	$output->default,
        );
        $current_location = json_encode($current_location);

        $data = [
            'getip' => $ipAddress,
            'getbrowser' => UserSystemInfoHelper::get_browsers(),
            'getdevice' => UserSystemInfoHelper::get_device(),
            'getos' => UserSystemInfoHelper::get_os(),
            'getcurrentLocation' => $current_location,
            'visit_time' => Carbon::now()
        ];

        $userIP = $this->visitorRepository->findVisitorIP($data['getip']);
        if($userIP){
            $data = [
                'ip_address' => $data['getip'],
                'visit_time' => $data['visit_time']
            ];
            $visitor = $this->visitorRepository->updateVisitor($data);
        } else {
            $data = [
                'ip_address' => $data['getip'],
                'browser' => $data['getbrowser'],
                'device' => $data['getdevice'],
                'os' => $data['getos'],
                'current_location' => $data['getcurrentLocation'],
                'visit_time' => $data['visit_time']
            ];
            $visitor = $this->visitorRepository->storeVisitor($data);
        }

        $products = Product::take(4)
        ->where('deleted', 0)
        ->get();

        $products_list1 = DB::table('products')
        ->where('deleted', 0)
        ->inRandomOrder()
        ->limit(4)
        ->get();


        $products_list2 = DB::table('products')
        ->where('deleted', 0)
        ->inRandomOrder()
        ->limit(4)
        ->get();


        return view('user/index', compact('products', 'products_list1', 'products_list2'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}