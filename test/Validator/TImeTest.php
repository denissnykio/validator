<?php
use PHPUnit\Framework\TestCase;
use Khalyomede\Validator;

class TimeTest extends TestCase {
    public function testTime() {
        $validator = new Validator([
            'start' => ['time']
        ]);

        $validator->validate([
            'start' => '20:44:09'
        ]);

        $this->assertEquals($validator->failed(), false);
    }

    public function testFailingTime() {
        $validator = new Validator([
            'start' => ['time']
        ]);

        $validator->validate([
            'start' => '20:44:61'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingTime2() {
        $validator = new Validator([
            'start' => ['time']
        ]);

        $validator->validate([
            'start' => '20:61:09'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingTime3() {
        $validator = new Validator([
            'start' => ['time']
        ]);

        $validator->validate([
            'start' => '25:44:09'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingTime4() {
        $validator = new Validator([
            'start' => ['time']
        ]);

        $validator->validate([
            'start' => '20:61:61'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingTime5() {
        $validator = new Validator([
            'start' => ['time']
        ]);

        $validator->validate([
            'start' => '25:44:61'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingTime6() {
        $validator = new Validator([
            'start' => ['time']
        ]);

        $validator->validate([
            'start' => '25:61:09'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingTime7() {
        $validator = new Validator([
            'start' => ['time']
        ]);

        $validator->validate([
            'start' => '25:61:61'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingTime8() {
        $validator = new Validator([
            'start' => ['time']
        ]);

        $validator->validate([
            'start' => '2018-11-15 20:44:09'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingTime9() {
        $validator = new Validator([
            'start' => ['time']
        ]);

        $validator->validate([
            'start' => 'bankai'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingTime10() {
        $validator = new Validator([
            'start' => ['time']
        ]);

        $validator->validate([
            'start' => 42
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingTime11() {
        $validator = new Validator([
            'start' => ['time']
        ]);

        $validator->validate([
            'start' => '20:44:09.07258'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingTime12() {
        $validator = new Validator([
            'start' => ['time']
        ]);

        $validator->validate([
            'start' => '200:44:09'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingTime13() {
        $validator = new Validator([
            'start' => ['time']
        ]);

        $validator->validate([
            'start' => '20:440:09'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingTime14() {
        $validator = new Validator([
            'start' => ['time']
        ]);

        $validator->validate([
            'start' => '20:44:090'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingTime15() {
        $validator = new Validator([
            'start' => ['time']
        ]);

        $validator->validate([
            'start' => '20:44:9'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingTime16() {
        $validator = new Validator([
            'start' => ['time']
        ]);

        $validator->validate([
            'start' => '20:4:09'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingTime17() {
        $validator = new Validator([
            'start' => ['time']
        ]);

        $validator->validate([
            'start' => '2:44:09'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingTime18() {
        $validator = new Validator([
            'start' => ['time']
        ]);

        $validator->validate([
            'start' => '20:4:9'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingTime19() {
        $validator = new Validator([
            'start' => ['time']
        ]);

        $validator->validate([
            'start' => '2:44:9'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingTime20() {
        $validator = new Validator([
            'start' => ['time']
        ]);

        $validator->validate([
            'start' => '2:4:09'
        ]);

        $this->assertEquals($validator->failed(), true);
    }

    public function testFailingTime21() {
        $validator = new Validator([
            'start' => ['time']
        ]);

        $validator->validate([
            'start' => '2:4:9'
        ]);

        $this->assertEquals($validator->failed(), true);
    }
}
?>