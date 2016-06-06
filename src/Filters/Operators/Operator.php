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
    * @var Detective\Filters\Separators\Separator
    */
    protected $field;


    /**
    * Give his builder and field to the separator
    * @param Detective\Contracts\Addable $separator
    * @param Detective\Database\Fields\Field $field
    */
    public function __construct(Addable $separator, $field)
    {
        $this->separator = $separator;

        $this->field = $field;
    }
}
