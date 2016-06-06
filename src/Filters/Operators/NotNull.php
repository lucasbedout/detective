<?php

namespace Detective\Filters\Operators;

use Illuminate\Database\Eloquent\Builder;
use Detective\Contracts\Addable;
use Detective\Contracts\Applyable;

class NotNull extends Operator implements Applyable
{
    /**
    * Apply a LIKE filter on the builder
    * @return Illuminate\Database\Eloquent\Builder
    */
    public function apply() : Builder
    {
        return $this->separator->add(function($q) {
            $q->whereNotNull($this->field->name);
        });
    }

}
