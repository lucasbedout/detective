<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class ProductsController extends BaseController
{
    public function index() 
    {
    	$products = \App\Product::all()->load(\App\Product::$eager);

    	return response()->json($products);
    }
}
