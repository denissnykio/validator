<?php
use PHPUnit\Framework\TestCase;
use Khalyomede\Validator;

class EmailTest extends TestCase {
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
}
?>