<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class StoresController extends BaseController
{
    public function index() 
    {
    	$stores = \App\Store::all();

    	return response()->json($stores);
    }
}
