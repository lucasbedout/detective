<?php 

namespace Detective;

class Model extends \Illuminate\Database\Eloquent\Model 
{

    public static $relationships = [];

    /**
     * @param $class Caller model
     * @param $parameter $filters
     * 
     * @return Eloquent\Model method call 
     **/ 
    public static function filter($parameters = null, $class = null) 
    {
        if (empty($class))
            $class = get_called_class();

        $context = new Database\Context($class);

        $builder = new Filters\Builder($context);

        return $builder->build($parameters);
    }
} 