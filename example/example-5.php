<?php
require __DIR__ . '/../vendor/autoload.php';

use Khalyomede\Validator;

$validator = new Validator([
    'sith' => ['required', 'array'],
    'sith.*' => ['string']
]);

$validator->validate([
    'sith' => ['Darth Maul', 'Darth Vador', 'Darth Sidious']
]);

var_dump( $validator->failed() ) // "false", hm... should have been true after all these guys did but anyway
?>