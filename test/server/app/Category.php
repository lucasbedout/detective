<?php

namespace App;

use Detective\Model;

class Category extends Model
{
	public static $relationships = ['products'];

	public function products() 
	{
		return $this->hasMany('App\Product');
	}
}
