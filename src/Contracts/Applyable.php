<?php

namespace Detective\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface Applyable {

    /**
    * Give his builder to the separator
    * @param Closure $callback
    * @return Illuminate\Database\Eloquent\Builder
    */
    public function apply() : Builder;
}
