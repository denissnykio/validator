<?php

use PHPUnit\Framework\TestCase;
use Khalyomede\Validator;

class SlugTest extends TestCase {
    public function testSlug() {
        $validator = new Validator([
            'title' => ['slug']
        ]);

        $validator->validate([
            'title' => 'test-driven-development-with-php-demystified'
        ]);

        $this->assertEquals($validator->failed(), false);
    }

    public function testFailingSlug() {
        $validator = new Validator([
            'title' => ['slug']
        ]);

        $validator->validate([
            'title' => 'test driven development with php demystified'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingSlug2() {
        $validator = new Validator([
            'title' => ['slug']
        ]);

        $validator->validate([
            'title' => 'Test-Driven-Development-With-Php-Demystified'
        ]);

        $this->assertEquals($validator->failed(), true);
    }
}