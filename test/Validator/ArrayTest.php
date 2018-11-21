<?php
use PHPUnit\Framework\TestCase;
use Khalyomede\Validator;
    
class ArrayTest extends TestCase {
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
            'hobbies' => ['array']
        ]);

        $this->validator2 = new Validator([
            'people.*.hobbies' => ['array']
        ]);
    }

    public function testArray() {
        $this->validator->validate(['hobbies' => ['programming', 'TV shows', 'workout']]);

        $this->assertFalse($this->validator->failed());
    }

    public function testArrayList()
    {
        $this->validator2->validate([
            'people' => [
                ['name' => 'John', 'hobbies' => ['programing', 'workout', 'watching tv shows']],
                ['name' => 'Foo', 'hobbies' => ['dancing', 'drawing', 'learning self improvement']],
                ['name' => 'Bar', 'hobbies' => ['photography', 'workout', 'politic']]
            ]
        ]);

        $this->assertFalse($this->validator2->failed());
    }

    public function testFailingArray() {
        $this->validator->validate(['hobbies' => 'programming, TV shows, workout']);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingArrayList()
    {
        $this->validator2->validate([
            'people' => [
                ['name' => 'John', 'hobbies' => ['programing', 'workout', 'watching tv shows']],
                ['name' => 'Foo', 'hobbies' => 'dancing, drawing, learning self improvement'],
                ['name' => 'Bar', 'hobbies' => ['photography', 'workout', 'politic']]
            ]
        ]);

        $this->assertTrue($this->validator2->failed());
    }
}
?>