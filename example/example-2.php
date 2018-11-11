<?php
/**
 * Example 2: testing if an element is present
 */
require __DIR__ . '/../vendor/autoload.php';

use Khalyomede\Validator;
use Khalyomede\Exception\UnknownRuleException;

$validator = new Validator(['name' => ['required', 'string']]);

try {
    $validator->validate(['name' => 'John']);
}
catch( UnknownRuleException $exception ) {
    echo "rule {$exception->getRule()} does not exist";
    
    exit(1);
}

var_dump($validator->failed()); // false
?>