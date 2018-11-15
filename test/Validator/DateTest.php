<?php
use PHPUnit\Framework\TestCase;
use Khalyomede\Validator;

class DateTest extends TestCase {
    public function testDate() {
        $validator = new Validator([
            'created_at' => ['date']
        ]);

        $validator->validate([
            'created_at' => '2018-11-14'
        ]);

        $this->assertEquals($validator->failed(), false);
    }

    public function testFailingDate() {
        $validator = new Validator([
            'created_at' => ['date']
        ]);

        $validator->validate([
            'created_at' => '2018-11-14 22:02:45'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingDate2() {
        $validator = new Validator([
            'created_at' => ['date']
        ]);

        $validator->validate([
            'created_at' => '2018'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingDate3() {
        $validator = new Validator([
            'created_at' => ['date']
        ]);

        $validator->validate([
            'created_at' => '2018-11'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingDate4() {
        $validator = new Validator([
            'created_at' => ['date']
        ]);

        $validator->validate([
            'created_at' => '2018/11/14'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingDate5() {
        $validator = new Validator([
            'created_at' => ['date']
        ]);

        $validator->validate([
            'created_at' => '2018-31-12'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingDate6() {
        $validator = new Validator([
            'created_at' => ['date']
        ]);

        $validator->validate([
            'created_at' => 42
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingDate7() {
        $validator = new Validator([
            'created_at' => ['date']
        ]);

        $validator->validate([
            'created_at' => 'kurosaki'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingDate8() {
        $validator = new Validator([
            'created_at' => ['date']
        ]);

        $validator->validate([
            'created_at' => '2018-11-150'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingDate9() {
        $validator = new Validator([
            'created_at' => ['date']
        ]);

        $validator->validate([
            'created_at' => '2018-110-15'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingDate10() {
        $validator = new Validator([
            'created_at' => ['date']
        ]);

        $validator->validate([
            'created_at' => '2018-110-150'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingDate11() {
        $validator = new Validator([
            'created_at' => ['date']
        ]);

        $validator->validate([
            'created_at' => '2018-1-15'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingDate12() {
        $validator = new Validator([
            'created_at' => ['date']
        ]);

        $validator->validate([
            'created_at' => '2018-11-1'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingDate13() {
        $validator = new Validator([
            'created_at' => ['date']
        ]);

        $validator->validate([
            'created_at' => '2018-1-1'
        ]);

        $this->assertEquals($validator->failed(), true);
    }
}
?>