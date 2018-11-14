<?php
use PHPUnit\Framework\TestCase;
use Khalyomede\Validator;

class UpperTest extends TestCase {
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