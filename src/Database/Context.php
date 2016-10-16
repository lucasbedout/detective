<?php

namespace Detective\Database;

use \DB;

class Context
{
    private $_class;

    private $_table;

    private $_primary_key;

    private $_relations = [];

    private $_fields = [];

    private $_nest;

    private $_integer_types = ['integer', 'bigint', 'float', 'decimal', 'smallint','decimal'];

    private $_string_types = ['string', 'text', 'blob'];

    private $_date_types = ['date', 'datetime', 'datetimetz', 'vardatetime', 'time'];


    /**
     * Set classname, relations and fields
     * @param $classname Name of the class
     * @return $this
     **/
    public function __construct($classname, $table = null, $nest = true)
    {
        $this->_class = $classname;
        $this->_nest = $nest;

        $this->_primary_key = (new $classname())->getKeyName();

        if (empty($table))
            $this->_table = (new $this->_class())->getTable();
        else
           $this->_table = $table;

        $this->setFields()->setRelations();

        return $this;
    }

    /**
     * List $_class fields
     * @return $this
     **/
    public function setFields()
    {
        $platform = DB::getDoctrineConnection()->getDatabasePlatform();
        $platform->registerDoctrineTypeMapping('_int4', 'string'); // handle unsupported postgres type
        $platform->registerDoctrineTypeMapping('json', 'text'); // handle unsupported postgres type
        $platform->registerDoctrineTypeMapping('jsonb', 'text'); // handle unsupported postgres type

        $columns = DB::getDoctrineSchemaManager()->listTableColumns($this->_table);

        foreach ($columns as $key => $column) {
            $this->_fields[$column->getName()] = $this->parseAtomicType($column->getType());
        }

        return $this;
    }

    public function getFields()
    {
        return $this->_fields;
    }

    public function getTable()
    {
        return $this->_table;
    }

    private function parseAtomicType($type)
    {
        $complete_type = strtolower($type);

        if (in_array($complete_type, $this->_integer_types))
            return 'number';
        else if (in_array($complete_type, $this->_date_types))
            return 'date';
        else
            return 'string';
    }

    /**
     * List $_class relations
     * @return $this
     **/
    public function setRelations()
    {
        if (!property_exists($this->_class, 'relationships'))
            return $this->_relations = [];

        $class = $this->_class;

        foreach ($class::$relationships as $key => $relation) {
            $relation_object = (new $class())->$relation();
            $relation_class = join('', array_slice(explode('\\', get_class($relation_object)), -1));

            $this->_relations[$relation] = [
                'type' => join('', array_slice(explode('\\', $relation_class), -1)),
                'model' => join('', array_slice(explode('\\', get_class($relation_object->getRelated())), -1)),
                'relation_primary_key' => $relation_object->getRelated()->getKeyName(),
                'relation_table' => $relation_object->getRelated()->getTable(),
            ];

            // Prevent infinite loops
            if ($this->_nest) {
                $relation_context = new Context(get_class($relation_object->getRelated()), null, false);
                $this->_relations[$relation]['relation_fields'] = $relation_context->getFields();
            }

            // Relation with pivot
            if (strtolower($relation_class) == 'belongstomany') {
                $this->_relations[$relation]['pivot_table'] = $relation_object->getTable();
                $this->_relations[$relation]['pivot_foreign_key'] = $relation_object->getForeignKey();
                $this->_relations[$relation]['pivot_other_key'] = $relation_object->getOtherKey();

                $pivot_context = new Context(get_class($relation_object->getRelated()), $relation_object->getTable(), false);
                $this->_relations[$relation]['pivot_fields'] = $pivot_context->getFields();
            } else {
                $this->_relations[$relation]['foreign_key'] = $relation_object->getForeignKey();
            }
        }
    }

    public function getRelations()
    {
        return $this->_relations;
    }

    public function getPrimaryKey()
    {
        return $this->_primary_key;
    }

    public function getClass()
    {
        return $this->_class;
    }
}
