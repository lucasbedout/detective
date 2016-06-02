<?php

namespace Detective\Testing\Models;

class Post extends \Detective\Model
{
    protected $relations = ['user'];
    
    public function user()
    {
        return $this->belongsTo('Detective\Testing\Models\User');
    }
}
