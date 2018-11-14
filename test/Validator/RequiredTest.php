<?php
use PHPUnit\Framework\TestCase;
use Khalyomede\Validator;

class RequiredTest extends TestCase {
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
}
?>