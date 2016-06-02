<?php

namespace Detective\Testing\Models;

class User extends \Detective\Model
{
    protected $relations = ['posts', 'reads'];

    public function posts()
    {
        return $this->hasMany('Detective\Testing\Models\Post');
    }

    public function reads()
    {
        return $this->belongsToMany('Detective\Testing\Models\Post', 'reads')->withTimestamps();
    }
}
