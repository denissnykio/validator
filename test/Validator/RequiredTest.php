<?php
use PHPUnit\Framework\TestCase;
use Khalyomede\Validator;

class RequiredTest extends TestCase {
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
            'name' => ['required']
        ]);

        $this->validator2 = new Validator([
            'names.*.origin' => ['required']
        ]);
    }

    public function testRequired() {
        $this->validator->validate(['name' => 'John']);

        $this->assertFalse($this->validator->failed());
    }

    public function testRequiredList()
    {
        $this->validator2->validate([
            'names' => [
                ['name' => 'Ichigo', 'origin' => 'Bleach'],
                ['name' => 'Naruto', 'origin' => 'Naruto'],
                ['name' => 'Gon', 'origin' => 'HunterXHunter']
            ]
        ]);

        $this->assertFalse($this->validator2->failed());
    }

    public function testFailingRequired() {
        $this->validator->validate(['name' => '']);

        $this->assertTrue($this->validator->failed());
    }

    public function testfailingRequired2() {
        $this->validator->validate(['name' => null]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingRequired3() {
        $this->validator->validate(['foo' => 'John']);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingRequiredList()
    {
        $this->validator2->validate([
            'names' => [
                ['name' => 'Ichigo', 'origin' => 'Bleach'],
                ['name' => 'Naruto', 'origin'],
                ['name' => 'Gon', 'origin' => 'HunterXHunter']
            ]
        ]);

        $this->assertTrue($this->validator2->failed());
    }
}
?>