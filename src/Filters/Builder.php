<?php 

namespace Detective\Filters;

use \DB;

class Builder  
{

    private $_context;

    private $_builder;

    private $_filters = [];

    private $_parameters;

    public function __construct($context)
    {
        $this->_context = $context;
        $class = $context->getClass();

        $this->_builder = $class::whereRaw('1 = 1');
    }

    /**
     * Build the query with users filters
     * @param $parameters User's parameters
     * @return Builder $this
     **/ 
    public function build($parameters)
    {
        if (!is_array($parameters) || empty($parameters) || count($parameters) == 0)
            return $this->_builder;

       foreach ($parameters as $attr => $value) {
            // Get param infos
            $this->_parameters[$attr] = $this->_parseAttributeName($attr);
            $this->_parameters[$attr]['value'] = $value;
        }

        $this->_run();

        if (array_key_exists('orderby', $parameters)) {
            $this->_orderBy($parameters);
        }

        return $this->_builder;
    }

    private function _run() 
    {
        foreach ($this->_parameters as $parameter) {
            if (isset($parameter['property_type']))
                $this->_addFilter($parameter);
        }

        foreach ($this->_filters as $key => $param) {
            $this->_addQuery($param);
        }
    }

    private function _orderBy($parameters) 
    {
        if (strpos($parameters['orderby'], ',') !== false) {
            $values = explode(',', $parameters['orderby']);
        } else {
            $values[0] = $parameters['orderby'];
        }

        $direction = array_key_exists('direction', $parameters) ? $parameters['direction'] : 'ASC';

        foreach ($values as $value) {
            $this->_builder = $this->_builder->orderBy($value, $direction);
        }
    }

    private function _addFilter($parameter) {
        $filter = new ValueParser($parameter['value'], $parameter['property_type'], null);

        $parameter['filters'] = $filter->get();

        $this->_filters[] = $parameter;
    }

    private function _addQuery($param)
    {
        if ($param['type'] == 'field') {
            $this->_builder = $this->_addFieldQuery($param);
        } else if ($param['type'] == 'relation') {
            $this->builder = $this->_addRelationQuery($param);
        }
    }

    private function _addFieldQuery($param) 
    {
        return $this->_builder->where(function($q) use ($param) {
            $q = $this->_generateQuery($q, $param);
        });
    }

    private function _addRelationQuery($param) 
    {
        $relations = $this->_context->getRelations();
        $relation_details = $relations[$param['model']];

        if (strtolower($relation_details['type']) != 'belongstomany')
            return $this->_addClassicRelationQuery($param, $relation_details);
            
        return $this->_addBelongsToManyQuery($param, $relation_details);
    }

    private function _addClassicRelationQuery($param, $relation)
    {
        return $this->_builder->whereHas($param['model'], function($q) use ($param, $relation) {
            if ($param['position'] != 'all')
                $q->where($relation['relation_primary_key'], '=', \DB::raw('(select ' . $param['position'] . '(' . $relation['relation_primary_key'] . ') from  ' . $relation['relation_table'] . ' where ' . $relation['foreign_key'] . '=' . $this->_context->getPrimaryKey() . ')'));

            $q->where(function($query) use ($param, $relation) {
                $query = $this->_generateQuery($query, $param);
            });
        });
    }

    private function _addBelongsToManyQuery($param, $relation)
    {
        return $this->_builder->whereHas($param['model'], function($q) use ($param, $relation) {
            foreach ($param['filters'] as $key => $filter) {
                if (isset($param['pivot_property'])) {
                    $q->whereRaw($relation['pivot_table'] . '.' . $param['pivot_property'] .  $filter['operator'] . $filter['value']);  
                } else {
                    if ($key == 0)
                        $q->where($param['property'], $filter['operator'], $filter['value']); 
                    else
                        $q->orWhere($param['property'], $filter['operator'], $filter['value']); 
                }
            }
        });
    }

    private function _generateQuery($q, $param)
    {
        foreach ($param['filters'] as $key => $filter) {
            if ($filter['operator'] == 'BETWEEN') {
                if ($key == 0 || $param['operator'] == 'AND')
                    $q->whereBetween($param['property'], array($filter['start'], $filter['end']));
                else 
                    $q->orWhereBetween($param['property'], array($filter['start'], $filter['end']));
            } else {
                if ($key == 0 || $param['operator'] == 'AND')
                    $q->where($param['property'], $filter['operator'], $filter['value']); 
                else
                    $q->orWhere($param['property'], $filter['operator'], $filter['value']); 
            }
        }

        return $q;
    }

    private function _parseAttributeName($attr) 
    {
        $parts = explode('-', $attr);
        $param = [];

        if (array_key_exists($parts[0], $this->_context->getFields())) {
            $fields = $this->_context->getFields();
            $param['type'] = 'field';
            $param['property'] = $attr;
            $param['property_type'] = $fields[$parts[0]];

            if (isset($parts[1])) {
                $param['parameter'] = $parts[1];
            }
        }

        if (array_key_exists($parts[0], $this->_context->getRelations())) {
            $param = $this->_getRelationAttributeInformations($parts);
        }

        if (isset($param['property_type']) && $param['property_type'] == 'date')
            $param['operator'] = 'AND';
        else 
            $param['operator'] = 'OR';

        return $param;
    }

    private function _getRelationAttributeInformations($parts) {
        $relations = $this->_context->getRelations();

        $param['type'] = 'relation';
        $param['model'] = $parts[0];
        $param['relation_type'] = strtolower($relations[$parts[0]]['type']);

        // Relation property
        if (!isset($parts[1]))
            $parts[1] = $relations[$parts[0]]['relation_primary_key'];

        if (isset($parts[1]) && $parts[1] != 'pivot' && array_key_exists($parts[1], $relations[$parts[0]]['relation_fields'])) {
            if (!isset($parts[2]) || ($parts[2] != 'min' && $parts[2] != 'last'))
                $param['position'] = 'all';
            else
               $param['position'] = $parts[2] == 'first' ? 'min' : 'max';

            // Set property name, type and relation sorting
            $param['property'] = $parts[1];
            $param['property_type'] = $relations[$parts[0]]['relation_fields'][$parts[1]];
        } else if (isset($parts[2]) && $parts[1] == 'pivot' && array_key_exists($parts[2], $relations[$parts[0]]['pivot_fields'])) {
            // Set pivot property name, type and relation sorting
            $param['pivot_property'] = $parts[2];
            $param['property_type'] = $relations[$parts[0]]['pivot_fields'][$parts[2]];
        }

        return $param;
    }
} 