<?php

namespace Detective\Database\Fields;

class Field {

    public $name;

    public $table;

    public $type;

    public function __construct($name, $type = null, $table = null)
    {
        $this->name = $name;

        $this->table = $table;

        $this->type = $type;
    }
}
