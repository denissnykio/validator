<?php
use PHPUnit\Framework\TestCase;
use Khalyomede\Validator;

class StringTest extends TestCase {
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
}
?>