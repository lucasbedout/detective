<?php

namespace Detective\Filters\Operators;

use Illuminate\Database\Eloquent\Builder;
use Detective\Contracts\Addable;
use Detective\Contracts\Applyable;

abstract class BasicOperator extends Operator
{
    /**
    * @var $value the value
    */
    protected $value;

    /**
    * Add separator, field and value to the operator
    * @param Detective\Contracts\Addable $separator
    * @param Detective\Database\Fields\Field $field
    * @param $value
    * @param $value
    */
    public function __construct(Addable $separator, $field, $value)
    {
        parent::__construct($separator, $field);

        $this->value = $value;
    }
}
