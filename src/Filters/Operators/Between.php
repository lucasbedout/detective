<?php

namespace Detective\Filters\Operators;

use Illuminate\Database\Eloquent\Builder;
use Detective\Contracts\Addable;
use Detective\Contracts\Applyable;

class Between extends Operator implements Applyable
{
    private $start;

    private $end; 

    /**
    * Add separator, field and value to the operator
    * @param Detective\Contracts\Addable $separator
    * @param Detective\Database\Fields\Field $field
    * @param $start
    * @param $end
    */
    public function __construct(Addable $separator, $field, $start, $end)
    {
        parent::__construct($separator, $field);

        $this->start = $start;

        $this->end = $end;
    }

    /**
    * Apply a between filter on the builder
    * @return Illuminate\Database\Eloquent\Builder
    */
    public function apply() : Builder
    {
        return $this->separator->add(function($q) {
            $q->whereBetween($this->field->name, [$this->start, $this->end]);
        });
    }

}
