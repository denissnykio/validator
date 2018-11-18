<?php
use PHPUnit\Framework\TestCase;
use Khalyomede\Validator;

class StringTest extends TestCase {
    /**
     * @var Khalyomede\Validator
     */
    protected $validator;

    /**
     * @var Khalyomede\Validator
     */

    public function setUp()
    {
        $this->validator = new Validator([
            'name' => ['string']
        ]);

        $this->validator2 = new Validator([
            'jedis.*' => ['string']
        ]);
    }

    public function testString() {
        $this->validator->validate(['name' => 'John']);

        $this->assertFalse($this->validator->failed());
    }

    public function testStringList()
    {
        $this->validator2->validate([
            'jedis' => ['qui-gonn jinn', 'obiwan kenobi', 'luke skywalker']
        ]);

        $this->assertFalse($this->validator->failed());
    }

    public function testFailingString() {
        $this->validator->validate(['name' => 42]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingStringList() {
        $this->validator->validate([
            'jedis' => ['qui-gonn jinn', 'obiwan kenobi', 42]
        ]);

        $this->assertTrue($this->validator->failed());
    }
}
?>