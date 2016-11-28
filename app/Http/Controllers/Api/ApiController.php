<?php

namespace App\Http\Controllers\Api;

use App\Client;
use App\Http\Requests;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function index()
    {
    	$clients = Client::orderBy('name')->get();

    	return view('api.index', compact('clients'));
    }

    public function balance(Request $request)
    {
    	if($request->has('meter_no')) {
    		if($request->has('remaining_balance')) {
    			$client = Client::where('meter_no', $request->input('meter_no'))->get();
    		}
    	}

    	return $client;
    }
}
