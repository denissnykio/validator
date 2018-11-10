# Validator

Validate arrays.


![PHP from Packagist](https://img.shields.io/packagist/php-v/khalyomede/validator.svg) ![Packagist](https://img.shields.io/packagist/v/khalyomede/validator.svg) ![Codeship](https://img.shields.io/codeship/692b2c10-c712-0136-43ce-66bc421a848b.svg) ![Packagist](https://img.shields.io/packagist/l/khalyomede/validator.svg)

```php
$validator = new Validator([
  'name' => ['required', 'string'],
  'hobbies' => ['array'],
  'hobbies.*' => ['string']
]);

$validator->validate([
  'name' => 'John', 
  'hobbies' => ['programming', 'comics', 'workout']
]);

var_dump($validator->failed()); // false
```

## Summary

- [Installation](#installation)
- [Examples](#examples)
- [Rules](#rules)

## Installation

In your project root:

```bash
composer require khalyomede\validator:0.*
```

## Examples

- [Example 1: validating a string](#example-1-validating-a-string)
- [Example 2: validating a required element](#example-2-validating-a-required-element)

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

### Example 2: validating a required element

```php
require __DIR__ . '/../vendor/autoload.php';

use Khalyomede\Validator;
use Khalyomede\Exception\UnknownRuleException;

$validator = new Validator(['name' => ['required', 'string']]);

try {
    $validator->validate(['name' => 'John']);

    var_dump($validator->failed()); // false
}
catch( UnknownRuleException $exception ) {
    echo "rule {$exception->getRule()} does not exist";

    exit(1);
}
```

## Rules

- [array](#array)
- [filled](#filled)
- [required](#required)
- [string](#string)
- [upper](#upper)

### array

Validate that a key is an array.

```php
$validator = new Validator([
    'hobbies' => ['array']
]);
```

### filled

Validate that a key is filled with a non empty value.

```php
$validator = new Validator([
    'name' => ['filled']
]);
```

### required

Validate that a key is present. The key can be empty by the way.

```php
$validator = new Validator([
    'name' => ['required']
]);
```

### string

Validate that a key is a string.

```php
$validator = new Validator([
    'name' = ['string']
]);
```

### upper

Validate that a string is only in uppercase.

```php
$validator = new Validator([
    'name' => ['uppercase']
]);
```