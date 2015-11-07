<?php

namespace App;

use Detective\Model;

class Product extends Model
{

	public static $eager = ['category', 'stores'];
	
	public function category() 
	{
		return $this->belongsTo('App\Category');
	}

	public function stores() 
	{
		return $this->belongsToMany('App\Store', 'products_stores')->withPivot('quantity');
	}
}
