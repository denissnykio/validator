<?php
use PHPUnit\Framework\TestCase;
use Khalyomede\Validator;
    
class ArrayTest extends TestCase {
    public function testArray() {
        $validator = new Validator(['hobbies' => ['array']]);

        $validator->validate(['hobbies' => ['programming', 'TV shows', 'workout']]);

        $this->assertEquals($validator->failed(), false);
    }

    public function testFailingArray() {
        $validator = new Validator(['hobbies' => ['array']]);

        $validator->validate(['hobbies' => 'programming, TV shows, workout']);

        $this->assertEquals($validator->failed(), true);
    }
}
?>