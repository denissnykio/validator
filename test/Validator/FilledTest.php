<?php
use PHPUnit\Framework\TestCase;
use Khalyomede\Validator;

class FilledTest extends TestCase {
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
            'name' => ['filled']
        ]);

        $this->validator2 = new Validator([
            'people.*.name' => ['filled']
        ]);
    }

    public function testFilled() {
        $this->validator->validate(['name' => 'John']);

        $this->assertEquals($this->validator->failed(), false);
    }

    public function testFilledList()
    {
        $this->validator2->validate([
            'people' => [
                ['name' => 'John', 'age' => 42],
                ['name' => 'Foo', 'age' => 38],
                ['name' => 'Bar', 'age' => 25]
            ]
        ]);

        $this->assertFalse($this->validator2->failed());
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

    public function testFailingFilledList()
    {
        $this->validator2->validate([
            'people' => [
                ['name' => 'John', 'age' => 42],
                ['name' => '', 'age' => 38],
                ['name' => 'Bar', 'age' => 25]
            ]
        ]);

        $this->assertTrue($this->validator2->failed());
    }
}
?>