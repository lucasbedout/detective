<?php

namespace Detective;

use Detective\Database\Relations\BasicRelation;
use Detective\Database\Relations\ManyToManyRelation;
use Detective\Database\Fields\Analyzer;
use DB;


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
     * Returns all fields with their type
     *
     * @return Collection
     **/
    public function fields()
    {
        $analyzer = new Analyzer($this->getTable());

        return $analyzer->fields();
    }

    /**
     * Returns all relations with their informations
     *
     * @return Collection
     **/
    public function relations()
    {
        // If there is no relation, juste return an empty collection
        if (!isset($this->relations))
            return collect();

        // Iterate over the relations and push them to the relations array
        return collect($this->relations)->map(function($relation) {
            // Save the relation object
            $relation_object = $this->$relation();

            // Choose the right class to use
            if (get_class_short_name($relation_object) == 'BelongsToMany') {
                // Many to many relation
                return new ManyToManyRelation($relation, $relation_object);
            } else {
                // Relation using a foreign key
                return new BasicRelation($relation, $relation_object);
            }
        });
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

        $filters = new Database\Context($class);

        $builder = new Filters\Builder($query, $context);

        return $builder->build($parameters);
    }
}
