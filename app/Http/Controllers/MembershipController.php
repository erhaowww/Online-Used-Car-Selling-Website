<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use \DOMDocument;
use \XSLTProcessor;

class MembershipController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = $this->client->request('GET', 'http://127.0.0.1:9000/api/memberships');
        $memberships = json_decode($response->getBody()->getContents(), true);
        return view('admin/all-membership', compact('memberships'));
    }

    public function membershipDetails($level)
    {
        $xml = new DOMDocument();
        $xml->load('../database/xml/customers.xml');

        // Apply the XSLT transformation to the XML document
        $xsl = new DOMDocument();
        $xsl->load('../database/xsl/membershipDetails.xsl');

        $proc = new XSLTProcessor();
        $proc->importStylesheet($xsl);
        $proc->setParameter('', 'level', $level);

        $html = $proc->transformToXML($xml);
        return view('admin/membershipDetails', compact('html'));
    }

    public function membershipAllDetails()
    {
        $xml = new DOMDocument();
        $xml->load('../database/xml/customers.xml');

        // Apply the XSLT transformation to the XML document
        $xsl = new DOMDocument();
        $xsl->load('../database/xsl/membershipAllDetails.xsl');

        $proc = new XSLTProcessor();
        $proc->importStylesheet($xsl);

        $html = $proc->transformToXML($xml);
        return view('admin/membershipAllDetails', compact('html'));
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
        //
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
