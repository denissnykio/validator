<?php
/**
 * Example 4: check if a rule do not exist before adding one.
 */
require __DIR__ . '/../vendor/autoload.php';

use Khalyomede\Validator;

if (Validator::has('ip') === false) {
    Validator::extends('ip', function($value, $key, $items) {
        return filter_var($value, FILTER_VALIDATE_IP) !== false;
    });
}

$validator = new Validator([
    'client' => ['ip']
]);

$validator->validate([
    'client' => '192.168.0.1'
]);

var_dump($validator->failed());
?>