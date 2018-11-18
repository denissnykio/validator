<?php

use PHPUnit\Framework\TestCase;
use Khalyomede\Validator;

class SlugTest extends TestCase {
    /**
     * @var Khalyomede\Validator
     */
    protected $validator;

    /**
     * @var Khayomede\Validator
     */
    protected $validator2;

    public function setUp()
    {
        $this->validator = new Validator([
            'title' => ['slug']
        ]);

        $this->validator2 = new Validator([
            'titles.*' => ['slug']
        ]);
    }

    public function testSlug() {
        $this->validator->validate([
            'title' => 'test-driven-development-with-php-demystified'
        ]);

        $this->assertFalse($this->validator->failed());
    }

    public function testSlugList()
    {
        $this->validator2->validate([
            'titles' => ['a-title', 'another-title', 'a-third-title']
        ]);

        $this->assertFalse($this->validator2->failed());
    }

    public function testFailingSlug() {
        $this->validator->validate([
            'title' => 'test driven development with php demystified'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingSlug2() {
        $this->validator->validate([
            'title' => 'Test-Driven-Development-With-Php-Demystified'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingSlugList()
    {
        $this->validator2->validate([
            'titles' => ['a-title', 'another title', 'a-third-title']
        ]);

        $this->assertTrue($this->validator2->failed());
    }
}