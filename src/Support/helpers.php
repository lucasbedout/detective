<?php

/**
* This function take an object as parameter and return the short class name
* @return string
*/
function get_class_short_name($object)
{
    $parts = explode('\\', get_class($object));

    return end($parts);
}
