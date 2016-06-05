<?php

namespace Detective\Filters\Separators;

use Illuminate\Database\Eloquent\Builder;
use Detective\Contracts\Addable;
use Closure;

class WhereHas extends Separator implements Addable {

    /**
    * @var Detective\Database\Relations\Relation $relation
    */
    private $relation;

    /**
    * Give his builder to the separator
    * @param Illuminate\Database\Eloquent\Builder $builder
    * @param Detective\Database\Relations\Relation $relation
    */
    public function __construct(Builder $builder, $relation)
    {
        parent::__construct($builder);

        $this->relation = $relation;
    }

    /**
    * Add a where separator to the query
    * @param Closure $callback Take the builder as parameter
    * @return Illuminate\Database\Eloquent\Builder
    */
    public function add(Closure $callback) : Builder
    {
        return $this->builder->whereHas($this->relation->method, function($q) use ($callback) {
            $callback($q);
        });
    }

}
