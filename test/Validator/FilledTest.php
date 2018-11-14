<?php
use PHPUnit\Framework\TestCase;
use Khalyomede\Validator;

class FilledTest extends TestCase {
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

    public function testFailingFilled2() {
        $validator = new Validator(['name' => ['filled']]);

        $validator->validate(['name' => null]);

        $this->assertEquals($validator->failed(), true);
    }
}
?>