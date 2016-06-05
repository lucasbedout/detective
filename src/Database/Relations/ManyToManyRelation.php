<?php

namespace Detective\Database\Relations;

use Detective\Database\Fields\Analyzer;

/**
* Represents a basic relation between 2 models, with a foreign key
*/
class ManyToManyRelation extends Relation
{
    /**
    * @var $table
    * Pivot table name
    */
    public $table;

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
    * @var $pivot_fields
    * Fields of the pivot table
    */
    public $pivot_fields;

    /**
    * Set the detective relation object from the eloquent one
    * @param $relation Eloquent relation object (belongsTo, etc..)
    * @return Relation $this
    */
    public function __construct($relation)
    {
        parent::__construct($relation);

        // Set the table
        $this->table = $relation->getTable();

        // Set the foreign key from eloquent
        $this->pivot_foreign_key = $relation->getForeignKey();

        // Set the related model key
        $this->pivot_other_key = $relation->getOtherKey();

        // Set pivot table fields
        $this->pivot_fields = (new Analyzer($this->table))->fields();

        return $this;
    }

}
