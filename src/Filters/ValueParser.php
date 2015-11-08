<?php 

namespace Detective\Filters;

use \DB;

class ValueParser  
{

    private $_values;

    private $_parameter;

    public function __construct($parameter, $type, $attr = null)
    {
        $this->_parameter = $parameter;

        $this->_type = $type;

        $this->_parse($attr);

        return $this;
    }

    private function _parse($attr = null) 
    {
        // Replace * by %
        $parameter = str_replace('*', '%', $this->_parameter);

        // Split with ','
        $values = explode(',', $parameter);

        foreach ($values as $key => $value) {
            $func = '_parse' . ucfirst($this->_type);

            $this->_values[] = $this->$func($value, $attr);
        }
    }

    public function get() 
    {
        return $this->_values;
    }

    private function _parseNumber($number, $attr) 
    {
        // Between
        if (strpos($number, '-') !== false) {
            return $this->_between($number);
        }

        // Superior or inferior 
        if (in_array($number[0], ['<', '>'])) {
            return ['operator' => $number[0], 'value' => ltrim($number, $number[0])];
        }

        // Different
        if (!empty($attr) && $attr == 'not') {
            return ['operator' => '!=', 'value' => $number];
        }

        // Classic =
        return ['operator' => '=', 'value' => $number];
    }

    private function _parseString($string, $attr) 
    {
        // NOT LIKE
        if (!empty($attr) && $attr == 'not') {
            return ['operator' => 'NOT LIKE', 'value' => $string];
        }

        // Classic LIKE
        return ['operator' => 'LIKE', 'value' => $string];
    }

    private function _parseDate($date, $attr) 
    {
        if (!empty($attr) && $attr == 'not') {
            return ['operator' => 'NOT LIKE', 'value' => $date];
        }

        // Superior or inferior 
        if (in_array($date[0], ['<', '>'])) {
            return ['operator' => $date[0], 'value' => ltrim($date, $date[0])];
        }

        if (strpos($date, '|') !== false) {
            $date = explode('|', $date);
            return ['operator' => '=', 'function' => $date[0], 'value' => $date[1]];
        }

        return ['operator' => 'LIKE', 'value' => $date];
    }

    private function _between($number)
    {
        $values = explode('-', $number);

        return [
            'operator' => 'BETWEEN',
            'start' => $values[0],
            'end' => $values[1] 
        ];
    }


    
} 