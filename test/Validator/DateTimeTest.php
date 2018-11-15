<?php
use PHPUnit\Framework\TestCase;
use Khalyomede\Validator;

class DateTimeTest extends TestCase {
    public function testDateTime() {
        $validator = new Validator([
            'updated_at' => ['datetime']
        ]);

        $validator->validate([
            'updated_at' => '2018-11-14 22:50:00'
        ]);

        $this->assertEquals($validator->failed(), false);
    }

    public function testFailingDateTime() {
        $validator = new Validator([
            'updated_at' => ['datetime']
        ]);

        $validator->validate([
            'updated_at' => 'ichigo'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingDateTime2() {
        $validator = new Validator([
            'updated_at' => ['datetime']
        ]);

        $validator->validate([
            'updated_at' => 2018
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingDateTime3() {
        $validator = new Validator([
            'updated_at' => ['datetime']
        ]);

        $validator->validate([
            'updated_at' => '2018-11-14 22:50:61'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingDateTime4() {
        $validator = new Validator([
            'updated_at' => ['datetime']
        ]);

        $validator->validate([
            'updated_at' => '2018-11-14 22:61:00'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingDateTime5() {
        $validator = new Validator([
            'updated_at' => ['datetime']
        ]);

        $validator->validate([
            'updated_at' => '2018-11-14 25:50:00'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingDateTime6() {
        $validator = new Validator([
            'updated_at' => ['datetime']
        ]);

        $validator->validate([
            'updated_at' => '2018-11-32 22:50:00'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingDateTime7() {
        $validator = new Validator([
            'updated_at' => ['datetime']
        ]);

        $validator->validate([
            'updated_at' => '2018-13-14 22:50:00'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingDateTime8() {
        $validator = new Validator([
            'updated_at' => ['datetime']
        ]);

        $validator->validate([
            'updated_at' => '2018-11-14'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingDateTime9() {
        $validator = new Validator([
            'updated_at' => ['datetime']
        ]);

        $validator->validate([
            'updated_at' => '2018-11-32'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingDateTime10() {
        $validator = new Validator([
            'updated_at' => ['datetime']
        ]);

        $validator->validate([
            'updated_at' => '2018-13-14'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingDateTIme11() {
        $validator = new Validator([
            'updated_at' => ['datetime']
        ]);

        $validator->validate([
            'updated_at' => '2018-11-14 22:50:0'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingDateTime12() {
        $validator = new Validator([
            'updated_at' => ['datetime']
        ]);

        $validator->validate([
            'updated_at' => '2018-11-14 22:5:00'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingDateTime13() {
        $validator = new Validator([
            'updated_at' => ['datetime']
        ]);

        $validator->validate([
            'updated_at' => '2018-11-14 2:50:00'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingDateTime14() {
        $validator = new Validator([
            'updated_at' => ['datetime']
        ]);

        $validator->validate([
            'updated_at' => '2018-11-1 22:50:00'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingDateTime15() {
        $validator = new Validator([
            'updated_at' => ['datetime']
        ]);

        $validator->validate([
            'updated_at' => '2018-1-14 22:50:00'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingDateTime16() {
        $validator = new Validator([
            'updated_at' => ['datetime']
        ]);

        $validator->validate([
            'updated_at' => '2018-1-1 22:50:00'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingDateTime17() {
        $validator = new Validator([
            'updated_at' => ['datetime']
        ]);

        $validator->validate([
            'updated_at' => '2018-1-14 2:50:00'
        ]);

        $this->assertEquals($validator->failed(), true);
    }
}
?>