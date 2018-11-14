<?php
use PHPUnit\Framework\TestCase;
use Khalyomede\Validator;

class LowerTest extends TestCase {
    public function testLower() {
        $validator = new Validator([
            'words' => ['lower']
        ]);

        $validator->validate([
            'words' => 'php 7.4 rocks!'
        ]);

        $this->assertEquals($validator->failed(), false);
    }

    public function testFailingLower() {
        $validator = new Validator([
            'words' => ['lower']
        ]);

        $validator->validate([
            'words' => 'PHP 7.4 rocks!'
        ]);

        $this->assertEquals($validator->failed(), true);
    }
}
?>