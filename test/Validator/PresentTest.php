<?php
use PHPUnit\Framework\TestCase;
use Khalyomede\Validator;

class PresentTest extends TestCase {
    public function testPresent() {
        $validator = new Validator([
            'lastname' => ['present']
        ]);

        $validator->validate([
            'lastname' => ''
        ]);

        $this->assertEquals($validator->failed(), false);
    }

    public function testFailingPresent() {
        $validator = new Validator([
            'lastname' => ['present']
        ]);

        $validator->validate([
            'firstname' => 'John'
        ]);

        $this->assertEquals($validator->failed(), true);
    }
}
?>