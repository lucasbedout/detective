<?php

namespace Detective\Testing\Models;

class User extends \Detective\Model
{
    protected $relations = ['posts'];

    public function posts()
    {
        return $this->hasMany('Detective\Testing\Models\Post');
    }
}
