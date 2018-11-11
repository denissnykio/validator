<?php
use PHPUnit\Framework\TestCase;
use Khalyomede\Validator;

class ValidatorTest extends TestCase {
    public function testString() {
        $validator = new Validator(['name' => ['string']]);

        $validator->validate(['name' => 'John']);

        $this->assertEquals($validator->failed(), false);
    }

    public function testArray() {
        $validator = new Validator(['hobbies' => ['array']]);

        $validator->validate(['hobbies' => ['programming', 'TV shows', 'workout']]);

        $this->assertEquals($validator->failed(), false);
    }

    public function testRequired() {
        $validator = new Validator(['name' => ['required']]);

        $validator->validate(['name' => '']);

        $this->assertEquals($validator->failed(), false);
    }

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
}
?>