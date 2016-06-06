<?php

namespace Detective\Filters\Operators;

use Illuminate\Database\Eloquent\Builder;
use Detective\Contracts\Applyable;

class NotIn extends BasicOperator implements Applyable
{
    /**
    * Apply a where not in filter on the builder
    * @return Illuminate\Database\Eloquent\Builder
    */
    public function apply() : Builder
    {
        return $this->separator->add(function($q) {
            $q->whereNotIn($this->field->name, $this->value);
        });
    }

}
