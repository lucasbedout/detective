<?php

namespace Detective\Database\Relations;

/**
* Represents a relation between two models (one is call first model, the other is called related model)
* It's an opinionated class built on the principle that we use a main model to filter our data
*/
class Relation
{
    /**
    * @var $type
    * Lowercased type of the relation (belongsto, hasmany,...)
    */
    public $type;

    /**
    * @var $model
    * First eloquent model
    */
    public $model;

    /**
    * @var $related_model
    * Related eloquent model
    */
    public $related_model;

    /**
    * @var $primary_key
    * Related model primary key
    */
    public $primary_key;

    /**
    * @var $related_fields
    * Related model fields
    */
    public $related_fields;

    /**
    * Set the detective relation object from the eloquent one
    * @param $relation Eloquent relation object (belongsTo, etc..)
    * @return Relation $this
    */
    public function __construct($relation)
    {
        // Set relation type first
        $this->type = strtolower(get_class_short_name($relation));

        // Then the first model
        $this->model = get_class($relation->getParent());

        // Find informations about the related model (key and fields)
        $related = $relation->getRelated();
        $this->related_model = get_class($related);
        $this->primary_key = $related->getKeyName();
        $this->related_fields = $related->fields();

        return $this;
    }

}
