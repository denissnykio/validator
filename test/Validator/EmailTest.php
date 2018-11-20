<?php
use PHPUnit\Framework\TestCase;
use Khalyomede\Validator;

class EmailTest extends TestCase {
    /**
     * @var Khalyomede\Validation
     */
    protected $validator;

    /**
     * @var Khalyomede\Validation
     */
    protected $validator2;

    public function setUp() {
        $this->validator = new Validator([
            'email' => ['email']
        ]);

        $this->validator2 = new Validator([
            'people.*.email' => ['email']
        ]);
    }

    public function testEmail() {
        $this->validator->validate(['email' => 'khalyomede@gmail.com']);

        $this->assertEquals($this->validator->failed(), false);
    }

    public function testEmailList()
    {
        $this->validator2->validate([
            'people' => [
                ['name' => 'John', 'email' => 'john.doe@gmail.com'],
                ['name' => 'Foo', 'email' => 'foo.bar@gmail.com'],
                ['name' => 'Baz', 'email' => 'foo.baz@gmaiL.com']
            ]
        ]);

        $this->assertFalse($this->validator2->failed());
    }

    public function testFailingEmail() {
        $this->validator->validate(['email' => 42]);

        $this->assertEquals($this->validator->failed(), true);
    }

    public function testFailingEmail2() {
        $this->validator->validate(['email' => 'khalyomede@gmail']);

        $this->assertEquals($this->validator->failed(), true);
    }

    public function testFailingEmailList()
    {
        $this->validator2->validate([
            'people' => [
                ['name' => 'John', 'email' => 'john.doe@gmail.com'],
                ['name' => 'Foo', 'email' => 'foo.bar@gmail'],
                ['name' => 'Baz', 'email' => 'foo.baz@gmaiL.com']
            ]
        ]);

        $this->assertTrue($this->validator2->failed());
    }
}
?>