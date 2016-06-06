<?php

namespace Detective\Filters\Operators;

use Illuminate\Database\Eloquent\Builder;
use Detective\Contracts\Addable;
use Detective\Contracts\Applyable;

class NotLike extends BasicOperator implements Applyable
{
    /**
    * Apply a LIKE filter on the builder
    * @return Illuminate\Database\Eloquent\Builder
    */
    public function apply() : Builder
    {
        return $this->separator->add(function($q) {
            $q->where($this->field->name, 'NOT LIKE', $this->value);
        });
    }

}
