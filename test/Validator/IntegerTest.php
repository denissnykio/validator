<?php
use PHPUnit\Framework\TestCase;
use Khalyomede\Validator;

class IntegerTest extends TestCase {
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