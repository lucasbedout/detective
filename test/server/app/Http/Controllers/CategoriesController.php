<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class CategoriesController extends BaseController
{
    public function index() 
    {
    	$categories = \App\Category::filter()->load(\App\Category::$relationships);

    	return response()->json($categories);
    }
}
