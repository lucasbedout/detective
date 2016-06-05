<?php

namespace Detective\Filters\Separators;

use Illuminate\Database\Eloquent\Builder;

abstract class Separator {

    /**
    * @var Illuminate\Database\Eloquent\Builder $builder, the eloquent builder
    */
    protected $builder;

    /**
    * Give his builder to the separator
    * @param Illuminate\Database\Eloquent\Builder
    */
    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }

}
