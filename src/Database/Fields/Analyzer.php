<?php

namespace Detective\Database\Fields;

use DB;

/**
* This class can analyze a table, find fields, types, etc..
*/
class Analyzer {

    /**
    * @var $table
    * Table to analyze
    */
    private $table;

    /**
    * @var $types
    * Correspondance between Doctrine and Detective field types
    */
    private $types = [
        'Detective\Database\Fields\Number'   => ['integer', 'bigint', 'float', 'decimal', 'smallint','decimal'],
        'Detective\Database\Fields\DateTime' => ['date', 'datetime', 'datetimetz', 'vardatetime', 'time'],
        'Detective\Database\Fields\Text'     => ['string', 'text', 'blob']
    ];

    public function __construct($table)
    {
        $this->table = $table;
    }

    public function fields()
    {
        // Get column from doctrine as a collection
        $columns = collect(DB::getDoctrineSchemaManager()->listTableColumns($this->table));

        return $columns->map(function($column) {
            $field_class = $this->parseType($column);
            return new $field_class($column);
        });
    }

    /**
     * Find the correct detective class for a given doctrine object
     * @param $doctrine_object The Doctrine object
     * @return string the type name
     **/
    private function parseType($doctrine_object)
    {   
        // Get the short name of the class (i.e IntegerType), lowercase it and remove the "type" word
        $class = str_replace('type', '', strtolower(get_class_short_name($doctrine_object->getType())));

        // Search the types array and return the key of the one containing the type
        return collect($this->types)->search(function($arr, $type) use ($class) {
            return in_array($class, $arr);
        });
    }
}
