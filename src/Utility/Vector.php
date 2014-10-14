<?php

namespace Utility;

/**
 * Library Vector
 * @package Utility
 */
class Vector
{
    /**
     * Extract all property values from a multidimensional array
     * @param mixed[] $data Multidimensional array
     * @param mixed $property Property to extract
     * @return mixed[]
     */
    public static function pluck($data, $property)
    {
        return array_reduce($data, function($result, $array) use($property) {
            isset($array[$property]) && $result[] = $array[$property];
            return $result;
        }, array());
    }


}
