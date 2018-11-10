<?php
namespace Khalyomede;

/**
 * Class that contains constants for differents regular expressions.
 * 
 * @category Helper
 * 
 * @package Validator
 * 
 * @author Khalyomede <khalyomede@gmail.com>
 * 
 * @license https://opensource.org/licenses/MIT MIT
 * 
 * @example 
 * $regexp = RegExp::UPPER;
 */
class RegExp {
    const UPPER = '/[[:upper:]]/';
    const NOT_UPPER = '/[^[:upper:]]/';
}
?>