<?php
use PHPUnit\Framework\TestCase;
use Khalyomede\Validator;

class HasTest extends TestCase {
    public function testHash() {
        $this->assertEquals(Validator::has('string'), true);
    }

    public function testFailingHas() {
        $this->assertEquals(Validator::has('shinigami'), false);
    }
}
?>