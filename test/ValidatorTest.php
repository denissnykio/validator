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

        $validator->validate(['name' => 'John']);

        $this->assertEquals($validator->failed(), false);
    }
}
?>