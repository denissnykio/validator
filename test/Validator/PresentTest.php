<?php
use PHPUnit\Framework\TestCase;
use Khalyomede\Validator;

class PresentTest extends TestCase {
    /**
     * @var Khalyomede\Validator
     */
    protected $validator;

    public function setUp() {
        $this->validator = new Validator([
            'lastname' => ['present']
        ]);
    }

    public function testPresent() {
        $this->validator->validate([
            'lastname' => ''
        ]);

        $this->assertEquals($this->validator->failed(), false);
    }

    public function testPresentWithNullValue()
    {
        $this->validator->validate([
            'lastname' => null
        ]);

        $this->assertFalse($this->validator->failed());
    }

    public function testFailingPresent()
    {
        $this->validator->validate([
            'firstname' => 'John'
        ]);

        $this->assertTrue($this->validator->failed());
    }
}
?>