<?php

namespace Detective\Filters\Operators;

use Illuminate\Database\Eloquent\Builder;
use Detective\Filters\Separators;
use Detective\Contracts\Addable;
use Detective\Contracts\Applyable;

abstract class Operator {

    /**
    * @var Detective\Filters\Separators\Separator
    */
    protected $separator;

    /**
    * Give his builder to the separator
    * @param Detective\Contracts\Addable $separator
    * @param Illuminate\Database\Eloquent\Builder $builder
    */
    public function __construct(Addable $separator)
    {
        $this->separator = $separator;
    }
}
