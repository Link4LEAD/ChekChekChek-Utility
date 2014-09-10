<?php

namespace Utility;

/**
 * Library String
 * @package Utility
 */
class String
{
    /**
	 * Remove all spaces from a string
	 * @param string $string
	 * @return string
	 */
	public static function removeWhitespace($string) {
		/**
		 * \0 :  NIL char
		 * \xC2 : non-breaking space
		 * \xA0 : non-breaking space
		 * \x0B : vertical tab
		 * \t : tab
		 */
		return preg_replace('/[\0\xC2\xA0\x0B\t\ \ \ \]+/u', '', $string);
	}
	
    /**
     * Generates a random string of alphanumeric characters
     * @param int $length Desired chain length
     * @param string $allowedChars Characters allowed
     * @return string Chaîne de caractères aléatoires
     */
	public static function randString($length = 10, $allowedChars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') 
    {
        if (!self::isPositiveInt($length)) {
            return false;
        }

        $randString = '';
        $allowedCharsLength = mb_strlen($allowedChars, 'UTF-8');
        for ($i = 0; $i < $length; $i++) {
            $randString .= mb_substr($allowedChars, mt_rand(0, ($allowedCharsLength - 1)), 1, 'UTF-8');
        }

        return $randString;
	}
    
    /**
	 * Checks that a variable is a positive integer
	 * @param mixed $mixed Variable to test
	 * @return boolean True if positive integer, false otherwise
	 */
	public static function isPositiveInt($mixed) {
		if (!isset($mixed) || is_bool($mixed)) {
			return false;
        }

		return filter_var($mixed, FILTER_VALIDATE_INT, array('options' => array('min_range' => 0))) ? true : false;
	}
}
