<?php

namespace Detective\Contracts;

use Illuminate\Database\Eloquent\Builder;
use \Closure;

interface Addable {

    /**
    * Give his builder to the separator
    * @param Closure $callback
    * @return Illuminate\Database\Eloquent\Builder
    */
    public function add(Closure $callback) : Builder;
}
