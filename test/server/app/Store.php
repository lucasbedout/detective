<?php

namespace App;

use Detective\Model;

class Store extends Model
{
	public static $eager = ['products', 'products.category'];

	public function products() 
	{
		return $this->belongsToMany('Products', 'products_stores')->withPivot('quantity');
	}
}
