<?php

namespace App;

use Detective\Model;

class Category extends Model
{
	public function procucts() 
	{
		return $this->hasMany('Product');
	}
}
