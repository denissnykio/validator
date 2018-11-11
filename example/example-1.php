<?php
/**
 * Example 1: simple usage
 */
require __DIR__ . '/../vendor/autoload.php';

use Khalyomede\Validator;
use Khalyomede\Exception\RuleNotFoundException;

$validator = new Validator([
    'name' => ['string']
]);

try {
    $validator->validate(['name' => 'John']);
}
catch( RuleNotFoundException $exception ) {
    echo "rule {$exception->getRule()} does not exists";
    
    exit(1);
}

var_dump($validator->failed()); // false
?>