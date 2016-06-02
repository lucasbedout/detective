<?php

namespace Detective;

use Detective\Database\Relations\BasicRelation;
use Detective\Database\Relations\ManyToManyRelation;


class Model extends \Illuminate\Database\Eloquent\Model
{
    /**
     * @var $relations
     * The user will add to the relations array any relation method name
     * he wants to add to the filtering capabilities
     *
     */
    protected $relations = [];

    /**
     * Returns all relations with their informations
     *
     * @return Collection
     **/
    public function relations()
    {
        $relations = collect();

        // If there is no relation, juste return the empty collection
        if (!isset($this->relations))
            return $relations;

        // Iterate over the relations and push them to the relations array
        collect($this->relations)->each(function($relation) use ($relations) {
            // Save the relation object
            $relation_object = $this->$relation();

            // Choose the right class to use
            if (get_class_short_name($relation_object) == 'BelongsToMany') {
                // Many to many relation
                $relations->push(new ManyToManyRelation($relation_object));
            } else {
                // Relation using a foreign key
                $relations->push(new BasicRelation($relation_object));
            }
        });

        return $relations;
    }

    /**
     * @param $parameter $filters
     *
     * @return Eloquent\Model method call
     **/
    public function scopeFilter($query, $parameters = null)
    {
        // Find the current called class
        $class = get_called_class();

        $context = new Database\Context($class);

        $builder = new Filters\Builder($query, $context);

        return $builder->build($parameters);
    }
}
