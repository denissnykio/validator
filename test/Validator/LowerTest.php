<?php
use PHPUnit\Framework\TestCase;
use Khalyomede\Validator;

class LowerTest extends TestCase {
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
            'words' => ['lower']
        ]);

        $this->validator2 = new Validator([
            'sentences.*' => ['lower']
        ]);
    }

    public function testLower() {
        $validator = new Validator([
            'words' => ['lower']
        ]);

        $validator->validate([
            'words' => 'php 7.4 rocks!'
        ]);

        $this->assertEquals($validator->failed(), false);
    }

    public function testLowerList()
    {
        $this->validator2->validate([
            'sentences' => [
                'do or do not there is no try',
                'just for once let me look on you with my own eyes',
                'i am just a simple man trying to make my way in the universe'
            ]
        ]);

        $this->assertFalse($this->validator2->failed());
    }

    public function testFailingLower() {
        $validator = new Validator([
            'words' => ['lower']
        ]);

        $validator->validate([
            'words' => 'PHP 7.4 rocks!'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingLowerList()
    {
        $this->validator2->validate([
            'sentences' => [
                'Do. Or do not. There is no try.',
                'Just for once, let me look on you with my own eyes.',
                'I’m just a simple man trying to make my way in the universe.'
            ]
        ]);

        $this->assertTrue($this->validator2->failed());
    }
}
?>