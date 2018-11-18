<?php
use PHPUnit\Framework\TestCase;
use Khalyomede\Validator;

class IntegerTest extends TestCase {
    /**
     * @var Khalyomede\Validator;
     */
    protected $validator;

    /**
     * @var Khalyomede\Validator;
     */
    protected $validator2;

    public function setUp()
    {
        $this->validator = new Validator([
            'age' => ['integer']
        ]);

        $this->validator2 = new Validator([
            'people.*.age' => ['integer']
        ]);
    }

    public function testInteger() {
        $validator = new Validator([
            'age' => ['integer']
        ]);

        $validator->validate([
            'age' => 42
        ]);
        
        $this->assertEquals($validator->failed(), false);
    }

    public function testIntegerList()
    {
        $this->validator2->validate([
            'people' => [
                ['firstname' => 'John', 'age' => 42],
                ['firsname' => 'Foo', 'age' => 38],
                ['firstname' => 'Bar', 'age' => 25]
            ]
        ]);

        $this->assertFalse($this->validator->failed());
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

    public function testFailingIntegerList()
    {
        $this->validator2->validate([
            'people' => [
                ['firstname' => 'John', 'age' => 42],
                ['firsname' => 'Foo'],
                ['firstname' => 'Bar', 'age' => 25]
            ]
        ]);

        $this->assertTrue($this->validator2->failed());
    }
}
?>