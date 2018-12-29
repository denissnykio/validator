<?php
use PHPUnit\Framework\TestCase;
use Khalyomede\Validator;
    
class SameTest extends TestCase {
    /**
     * @var Khalyomede\Validator
     */
    protected $validator;

    public function setUp()
    {
        $this->validator = new Validator([
            'password' => ['same:password-confirm'],
            'password-confirm' => ['string']
        ]);
    }

    public function testSameFields()
    {
        $this->validator->validate([
            'password' => 'f2dJeN5vV62vrdM',
            'password-confirm' => 'f2dJeN5vV62vrdM'
        ]);

        $this->assertFalse($this->validator->failed());
    }

    public function testSameFields2()
    {
        $this->validator->validate([
            'password' => '',
            'password-confirm' => ''
        ]);

        $this->assertFalse($this->validator->failed());
    }

    public function testFailingSameFields()
    {
        $this->validator->validate([
            'password' => 'f2dJeN5vV62vrdM',
            'password-confirm' => 'foo'
        ]);

        $this->assertTrue($this->validator->failed());
    }
}
?>