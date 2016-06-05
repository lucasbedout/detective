<?php

namespace Detective\Filters\Separators;

use Illuminate\Database\Eloquent\Builder;
use Detective\Contracts\Addable;
use Closure;

class OrWhere extends Separator implements Addable {

    /**
    * Add a where separator to the query
    * @param Closure $callback Take the builder as parameter
    * @return Illuminate\Database\Eloquent\Builder
    */
    public function add(Closure $callback) : Builder
    {
        return $this->builder->orWhere(function($q) use ($callback) {
            $callback($q);
        });
    }

}
