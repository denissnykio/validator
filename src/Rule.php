<?php
namespace Khalyomede;

use ReflectionClass;

/**
 * Modelize the rules for validating an array.
 * 
 * @category Helper
 * 
 * @package Validator
 * 
 * @author Khalyomede <khalyomede@gmail.com>
 * 
 * @license https://opensource.org/licenses/MIT MIT
 * 
 * @link https://github.com/khalyomede/validator/blob/master/src/Rule.php
 */
class Rule {
    const STRING = 'string';
    const ARRAY = 'array';
    const REQUIRED = 'required';
    const FILLED = 'filled';
    const UPPER = 'upper';
    const EMAIL = 'email';
    const INTEGER = 'integer';
    const LOWER = 'lower';
    const SLUG = 'slug';
    const DATE = 'date';

    /**
     * Returns all the rules.
     * 
     * @return array<array>
     */
    public static function all(): array 
    {
        return array_values((new ReflectionClass(self::class))->getConstants());
    }
}
?>