<?php
/**
 * Example 3: adding a rule that is not in the available rules.
 */
require __DIR__ . '/../vendor/autoload.php';

use Khalyomede\Validator;
use Khalyomede\Exception\RuleAlreadyExistException;
use Khalyomede\Exception\RuleNotFoundException;

try {
    Validator::extends('longitude', function($value, $key, $items) {
        return is_float($value) && ($value >= -180) && ($value <= 180);
    });
}
catch( RuleAlreadyExistException $exception ) {
    echo "rule {$exception->getRule()} already exist";

    exit(1);
}
?>