<?php
use PHPUnit\Framework\TestCase;
use Khalyomede\Validator;

class DateTimeTest extends TestCase {
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
            'updated_at' => ['datetime']
        ]);

        $this->validator2 = new Validator([
            'orders.*.updated_at' => ['datetime']
        ]);
    }

    public function testDateTime() {
        $this->validator->validate([
            'updated_at' => '2018-11-14 22:50:00'
        ]);

        $this->assertFalse($this->validator->failed());
    }

    public function testDatetimeList()
    {
        $this->validator2->validate([
            'orders' => [
                ['product' => 'ice cream', 'updated_at' => '2018-11-14 22:50:00'],
                ['product' => 'pancakes', 'updated_at' => '2018-11-20 23:22:00'],
                ['product' => 'orange juice', 'updated_at' => '2018-11-20 23:33:07']
            ]
        ]);

        $this->assertFalse($this->validator2->failed());
    }

    public function testFailingDateTime() {
        $this->validator->validate([
            'updated_at' => 'ichigo'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingDateTime2() {
        $this->validator->validate([
            'updated_at' => 2018
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingDateTime3() {
        $this->validator->validate([
            'updated_at' => '2018-11-14 22:50:61'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingDateTime4() {
        $this->validator->validate([
            'updated_at' => '2018-11-14 22:61:00'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingDateTime5() {
        $this->validator->validate([
            'updated_at' => '2018-11-14 25:50:00'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingDateTime6() {
        $this->validator->validate([
            'updated_at' => '2018-11-32 22:50:00'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingDateTime7() {
        $this->validator->validate([
            'updated_at' => '2018-13-14 22:50:00'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingDateTime8() {
        $this->validator->validate([
            'updated_at' => '2018-11-14'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingDateTime9() {
        $this->validator->validate([
            'updated_at' => '2018-11-32'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingDateTime10() {
        $this->validator->validate([
            'updated_at' => '2018-13-14'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingDateTIme11() {
        $this->validator->validate([
            'updated_at' => '2018-11-14 22:50:0'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingDateTime12() {
        $this->validator->validate([
            'updated_at' => '2018-11-14 22:5:00'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingDateTime13() {
        $this->validator->validate([
            'updated_at' => '2018-11-14 2:50:00'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingDateTime14() {
        $this->validator->validate([
            'updated_at' => '2018-11-1 22:50:00'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingDateTime15() {
        $this->validator->validate([
            'updated_at' => '2018-1-14 22:50:00'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingDateTime16() {
        $this->validator->validate([
            'updated_at' => '2018-1-1 22:50:00'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingDateTime17() {
        $this->validator->validate([
            'updated_at' => '2018-1-14 2:50:00'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingDatetimeList()
    {
        $this->validator2->validate([
            'orders' => [
                ['product' => 'ice cream', 'updated_at' => '2018-11-14 22:50:00'],
                ['product' => 'pancakes', 'updated_at' => '2018-11-2018 23:22:00'],
                ['product' => 'orange juice', 'updated_at' => '2018-11-20 23:33:07']
            ]
        ]);

        $this->assertTrue($this->validator2->failed());
    }
}
?>