# Validator

Validate arrays.

```php
$validator = new Validator([
  'name' => ['required', 'string'],
  'hobbies' => ['array'],
  'hobbies.*' => ['string']
]);

$validator->validate([
  'name' => 'John', 
  'hobbies' => ['', '', '']
]);

var_dump($validator->failed()); // false
```

## Summary

- [Installation](#installation)
- [Examples](#examples)

## Installation

In your project root:

```bash
composer require khalyomede\validator:0.*
```

## Examples

- [Example 1: validating a string](#example-1-validating-a-string)

### Example 1: validating a string

```php
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
```