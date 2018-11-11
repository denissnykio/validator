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
 * @link https://github.com/khalyomede/validator/blob/master/src/RegExp.php
 * 
 * @example 
 * $regexp = RegExp::UPPER;
 */
class RegExp {
    const UPPER = '/[[:upper:]]/';
    const NOT_UPPER = '/[^[:upper:]]/';
}
?>