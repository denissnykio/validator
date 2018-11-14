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
    const NOT_UPPER = '/[[:lower:]]/';
    const NOT_LOWER = '/[[:upper:]]/';
    
    /** 
     * Tests for "not slug" regexp.
     * 
     * @see https://regex101.com/r/7EuROf/1/tests 
     */
    const NOT_SLUG = '/[^a-z-0-9]/'; 
}
?>