<?php
use PHPUnit\Framework\TestCase;
use Khalyomede\Validator;

class DateTest extends TestCase {
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
            'created_at' => ['date']
        ]);

        $this->validator2 = new Validator([
            'people.*.birth_date' => ['date']
        ]);
    }

    public function testDate() {
        $this->validator->validate([
            'created_at' => '2018-11-14'
        ]);

        $this->assertFalse($this->validator->failed());
    }

    public function testDateList()
    {
        $this->validator2->validate([
            'people' => [
                ['name' => 'John', 'birth_date' => '1970-01-01'],
                ['name' => 'Foo', 'birth_date' => '2018-12-07'],
                ['name' => 'Bar', 'birth_date' => '2018-11-21']
            ]
        ]);

        $this->assertFalse($this->validator2->failed());
    }

    public function testFailingDate() {
        $this->validator->validate([
            'created_at' => '2018-11-14 22:02:45'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingDate2() {
        $this->validator->validate([
            'created_at' => '2018'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingDate3() {
        $this->validator->validate([
            'created_at' => '2018-11'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingDate4() {
        $this->validator->validate([
            'created_at' => '2018/11/14'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingDate5() {
        $this->validator->validate([
            'created_at' => '2018-31-12'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingDate6() {
        $this->validator->validate([
            'created_at' => 42
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingDate7() {
        $this->validator->validate([
            'created_at' => 'kurosaki'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingDate8() {
        $this->validator->validate([
            'created_at' => '2018-11-150'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingDate9() {
        $this->validator->validate([
            'created_at' => '2018-110-15'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingDate10() {
        $this->validator->validate([
            'created_at' => '2018-110-150'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingDate11() {
        $this->validator->validate([
            'created_at' => '2018-1-15'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingDate12() {
        $this->validator->validate([
            'created_at' => '2018-11-1'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingDate13() {
        $this->validator->validate([
            'created_at' => '2018-1-1'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function failingDateList()
    {
        $this->validator2->validate([
            'people' => [
                ['name' => 'John', 'birth_date' => '1970-01-01'],
                ['name' => 'Foo', 'birth_date' => '2018-12-2018'],
                ['name' => 'Bar', 'birth_date' => '2018-11-21']
            ]
        ]);

        $this->assertTrue($this->validator2->failed());
    }
}
?>