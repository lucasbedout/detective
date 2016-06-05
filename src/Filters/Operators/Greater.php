<?php

namespace Detective\Filters\Operators;

use Illuminate\Database\Eloquent\Builder;
use Detective\Contracts\Addable;
use Detective\Contracts\Applyable;

class Greater extends Operator implements Applyable
{
    /**
    * @var Detective\Database\Fields\Field $field the detective field
    */
    private $field;

    /**
    * @var $value the value
    */
    private $value;

    /**
    * Add separator, field and value to the operator
    * @param Detective\Contracts\Addable $separator
    * @param Detective\Database\Fields\Field $field
    * @param $value
    */
    public function __construct(Addable $separator, $field, $value)
    {
        parent::__construct($separator);

        $this->field = $field;

        $this->value = $value;
    }

    /**
    * Apply the operator filter on the builder
    * @return Illuminate\Database\Eloquent\Builder
    */
    public function apply() : Builder
    {
        return $this->separator->add(function($q) {
            $q->where($this->field->name, '>', $this->value);
        });
    }

}
