<?php
use PHPUnit\Framework\TestCase;
use Khalyomede\Validator;

class UpperTest extends TestCase {
    /**
     * @var Khalyomede\Validator
     */
    protected $validator;

    /**
     * @var Khalyomede\Validator
     */
    protected $validator2;

    public function setUp()
    {
        $this->validator = new Validator([
            'name' => ['upper']
        ]);

        $this->validator2 = new Validator([
            'names.*' => ['upper']
        ]);
    }

    public function testUpper() {
        $this->validator->validate(['name' => 'JOHN']);

        $this->assertFalse($this->validator->failed());
    }

    public function testUpperList()
    {
        $this->validator2->validate([
            'names' => ['JOHN', 'FOO', 'BAR']
        ]);

        $this->assertFalse($this->validator2->failed());
    }

    public function testFailingUpper() {
        $this->validator->validate(['name' => 'John']);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingUpper2() {
        $this->validator->validate(['name' => 42]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingUpper3() {
        $this->validator->validate(['name' => null]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingUpperList() {
        $this->validator2->validate([
            'names' => ['John', 'Foo', 'Bar']
        ]);

        $this->assertTrue($this->validator2->failed());
    }
}
?>