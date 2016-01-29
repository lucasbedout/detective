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
    public function scopeFilter($query, $parameters = null, $class = null) 
    {
        if (empty($class))
            $class = get_called_class();

        $context = new Database\Context($class);

        $builder = new Filters\Builder($query, $context);

        return $builder->build($parameters);
    }

    public static function getContext($class)
    {
        return new Database\Context($class);
    }
} 