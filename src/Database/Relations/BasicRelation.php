<?php

namespace Detective\Database\Relations;


/**
* Represents a basic relation between 2 models, with a foreign key
*/
class BasicRelation extends Relation
{
    /**
    * @var $foreign_key
    * Foreign key on the first model
    */
    public $foreign_key;

    /**
    * Set the detective relation object from the eloquent one
    * @param $relation Eloquent relation object (belongsTo, etc..)
    * @return Relation $this
    */
    public function __construct($method, $relation)
    {
        parent::__construct($method, $relation);

        $this->foreign_key = $relation->getForeignKey();

        return $this;
    }

}
