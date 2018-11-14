<?php
/**
 * Example 4: check if a rule do not exist before adding one.
 */
require __DIR__ . '/../vendor/autoload.php';

use Khalyomede\Validator;

if (Validator::has('ip') === false) {
    echo "rule ip does not exist yet";
}
?>