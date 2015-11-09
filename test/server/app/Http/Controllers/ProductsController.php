<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use \App\Product;

class ProductsController extends BaseController
{
    public function index() 
    {
    	$products = Product::filter(\Input::all())->get()->load(Product::$relationships);

    	return response()->json($products);
    }
}
