<?php
use PHPUnit\Framework\TestCase;
use Khalyomede\Validator;
use Khalyomede\Exception\RuleAlreadyExistException;

class ValidatorTest extends TestCase {
    // string
    public function testString() {
        $validator = new Validator(['name' => ['string']]);

        $validator->validate(['name' => 'John']);

        $this->assertEquals($validator->failed(), false);
    }

    public function testFailingString() {
        $validator = new Validator(['name' => ['string']]);

        $validator->validate(['name' => 42]);

        $this->assertEquals($validator->failed(), true);
    }

    // array
    public function testArray() {
        $validator = new Validator(['hobbies' => ['array']]);

        $validator->validate(['hobbies' => ['programming', 'TV shows', 'workout']]);

        $this->assertEquals($validator->failed(), false);
    }

    public function testFailingArray() {
        $validator = new Validator(['hobbies' => ['array']]);

        $validator->validate(['hobbies' => 'programming, TV shows, workout']);

        $this->assertEquals($validator->failed(), true);
    }

    // required
    public function testRequired() {
        $validator = new Validator(['name' => ['required']]);

        $validator->validate(['name' => '']);

        $this->assertEquals($validator->failed(), false);
    }

    public function testfailingRequired() {
        $validator = new Validator(['name' => ['required']]);

        $validator->validate(['name' => null]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingRequired2() {
        $validator = new Validator(['name' => ['required']]);

        $validator->validate(['foo' => 'John']);

        $this->assertEquals($validator->failed(), true);
    }

    // filled
    public function testFilled() {
        $validator = new Validator(['name' => ['filled']]);

        $validator->validate(['name' => 'John']);

        $this->assertEquals($validator->failed(), false);
    }

    public function testFailingFilled() {
        $validator = new Validator(['name' => ['filled']]);

        $validator->validate(['name' => '']);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingFilled2() {
        $validator = new Validator(['name' => ['filled']]);

        $validator->validate(['name' => null]);

        $this->assertEquals($validator->failed(), true);
    }

    // upper
    public function testUpper() {
        $validator = new Validator(['name' => ['upper']]);

        $validator->validate(['name' => 'JOHN']);

        $this->assertEquals($validator->failed(), false);
    }

    public function testFailingUpper() {
        $validator = new Validator(['name' => ['upper']]);

        $validator->validate(['name' => 'John']);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingUpper2() {
        $validator = new Validator(['name' => ['upper']]);

        $validator->validate(['name' => 42]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingUpper3() {
        $validator = new Validator(['name' => ['upper']]);

        $validator->validate(['name' => null]);

        $this->assertEquals($validator->failed(), true);
    }

    // email
    public function testEmail() {
        $validator = new Validator(['email' => ['email']]);

        $validator->validate(['email' => 'khalyomede@gmail.com']);

        $this->assertEquals($validator->failed(), false);
    }

    public function testFailingEmail() {
        $validator = new Validator(['email' => ['email']]);

        $validator->validate(['email' => 42]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingEmail2() {
        $validator = new Validator(['email' => ['email']]);

        $validator->validate(['email' => 'khalyomede@gmail']);

        $this->assertEquals($validator->failed(), true);
    }

    // extends
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

    // has
    public function testHash() {
        $this->assertEquals(Validator::has('string'), true);
    }

    public function testFailingHas() {
        $this->assertEquals(Validator::has('shinigami'), false);
    }

    // integer
    public function testInteger() {
        $validator = new Validator([
            'age' => ['integer']
        ]);

        $validator->validate([
            'age' => 42
        ]);
        
        $this->assertEquals($validator->failed(), false);
    }

    public function testFailingInteger() {
        $validator = new Validator([
            'age' => ['integer']
        ]);

        $validator->validate([
            'age' => 'fourty two'
        ]);

        $this->assertEquals($validator->failed(), true);
    }
}
?>