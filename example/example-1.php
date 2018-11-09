<?php
/**
 * Example 1: simple usage
 */
require __DIR__ . '/../vendor/autoload.php';

use Khalyomede\Validator;
use Khalyomede\Exception\UnknownRuleException;

$validator = new Validator([
    'name' => ['string']
]);

try {
    $validator->validate(['name' => 'John']);

    var_dump($validator->failed()); // false
}
catch( UnknownRuleException $exception ) {
    echo "rule {$exception->getRule()} does not exists";

    exit(1);
}
?>