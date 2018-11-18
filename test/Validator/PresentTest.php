<?php
use PHPUnit\Framework\TestCase;
use Khalyomede\Validator;

class PresentTest extends TestCase {
    /**
     * @var Khalyomede\Validator
     */
    protected $validator;

    /**
     * @var Khalyomede\Validator
     */
    protected $validator2;

    public function setUp() {
        $this->validator = new Validator([
            'lastname' => ['present']
        ]);
        
        $this->validator2 = new Validator([
            'people.*.lastname' => ['present']
        ]);
    }

    public function testPresent() {
        $this->validator->validate([
            'lastname' => ''
        ]);

        $this->assertFalse($this->validator->failed());
    }

    public function testPresentList()
    {
        $this->validator2->validate([
            'people' => [
                ['firstname' => 'John', 'lastname' => 'Doe'],
                ['firstname' => 'Foo', 'lastname' => 'Bar'],
                ['firstname' => 'Foo', 'lastname' => 'Baz']
            ]
        ]);

        $this->assertFalse($this->validator2->failed());
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

    public function testFailingPresentList()
    {
        $this->validator2->validate([
            'people' => [
                ['firstname' => 'John', 'lastname' => 'Doe'],
                ['firstname' => 'Foo'],
                ['firstname' => 'Foo', 'lastname' => 'Baz']
            ]
        ]);

        $this->assertTrue($this->validator2->failed());
    }
}
?>