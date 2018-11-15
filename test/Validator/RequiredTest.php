<?php
use PHPUnit\Framework\TestCase;
use Khalyomede\Validator;

class RequiredTest extends TestCase {
    public function testRequired() {
        $validator = new Validator(['name' => ['required']]);

        $validator->validate(['name' => 'John']);

        $this->assertEquals($validator->failed(), false);
    }

    public function testFailingRequired() {
        $validator = new Validator(['name' => ['required']]);

        $validator->validate(['name' => '']);

        $this->assertEquals($validator->failed(), true);
    }

    public function testfailingRequired2() {
        $validator = new Validator(['name' => ['required']]);

        $validator->validate(['name' => null]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingRequired3() {
        $validator = new Validator(['name' => ['required']]);

        $validator->validate(['foo' => 'John']);

        $this->assertEquals($validator->failed(), true);
    }
}
?>