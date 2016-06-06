<?php

namespace Detective\Filters\Operators;

use Illuminate\Database\Eloquent\Builder;
use Detective\Contracts\Applyable;

class In extends BasicOperator implements Applyable
{
    /**
    * Apply a in  filter on the builder
    * @return Illuminate\Database\Eloquent\Builder
    */
    public function apply() : Builder
    {
        return $this->separator->add(function($q) {
            $q->whereIn($this->field->name, $this->value);
        });
    }

}
