<?php
use PHPUnit\Framework\TestCase;
use Khalyomede\Validator;
use Khalyomede\Exception\RuleAlreadyExistException;

class ExtendsTest extends TestCase {
    public function testExtends() {        
        Validator::extends('url', function($value, $key, $items) {
            return filter_var($value, FILTER_VALIDATE_URL) !== false;
        });

        $validator = new Validator(['twitter' => ['url']]);

        $validator->validate(['twitter' => 'https://twitter.com/laravelphp']);

        $this->assertEquals($validator->failed(), false);
    }

    public function testFailingExtends() {
        Validator::extends('url2', function($value, $key, $items) {
            return filter_var($value, FILTER_VALIDATE_URL) !== false;
        });

        $validator = new Validator(['twitter' => ['url2']]);

        $validator->validate(['twitter' => 'Laravel']);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingExtends2() {
        $this->expectException(RuleAlreadyExistException::class);

        Validator::extends('string', function($value, $key, $items) {
            return isset($items[$key]) === true && is_string($value) === true;
        });
    }

    public function testFailingExtends3() {
        $this->expectExceptionMessage('rule string already exist');

        Validator::extends('string', function($value, $key, $items) {
            return isset($items[$key]) === true && is_string($value) === true;
        });
    }
}
?>