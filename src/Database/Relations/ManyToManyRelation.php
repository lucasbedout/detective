<?php

namespace Detective\Database\Relations;

/**
* Represents a basic relation between 2 models, with a foreign key
*/
class ManyToManyRelation extends Relation
{
    /**
    * @var $pivot_foreign_key
    * Foreign key on the pivot table (first model reference)
    */
    public $pivot_foreign_key;

    /**
    * @var $pivot_other_key
    * Other key on the pivot table (related model reference)
    */
    public $pivot_other_key;

    /**
    * Set the detective relation object from the eloquent one
    * @param $relation Eloquent relation object (belongsTo, etc..)
    * @return Relation $this
    */
    public function __construct($relation)
    {
        parent::__construct($relation);

        // Set the foreign key from eloquent
        $this->pivot_foreign_key = $relation->getForeignKey();

        // Set the related model key 
        $this->pivot_other_key = $relation->getOtherKey();

        return $this;
    }

}
