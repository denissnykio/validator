<?php
use PHPUnit\Framework\TestCase;
use Khalyomede\Validator;

class TimeTest extends TestCase {
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
            'start' => ['time']
        ]);

        $this->validator2 = new Validator([
            'starts.*' => ['time']
        ]);
    }
    
    public function testTime() {
        $this->validator->validate([
            'start' => '20:44:09'
        ]);

        $this->assertFalse($this->validator->failed());
    }

    public function testTimeList() {
        $this->validator2->validate([
            'starts' => ['20:44:09', '12:59:00', '05:03:30']
        ]);

        $this->assertFalse($this->validator2->failed());
    }

    public function testFailingTime() {
        $this->validator->validate([
            'start' => '20:44:61'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingTime2() {
        $this->validator->validate([
            'start' => '20:61:09'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingTime3() {
        $this->validator->validate([
            'start' => '25:44:09'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingTime4() {
        $this->validator->validate([
            'start' => '20:61:61'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingTime5() {
        $this->validator->validate([
            'start' => '25:44:61'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingTime6() {
        $this->validator->validate([
            'start' => '25:61:09'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingTime7() {
        $this->validator->validate([
            'start' => '25:61:61'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingTime8() {
        $this->validator->validate([
            'start' => '2018-11-15 20:44:09'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingTime9() {
        $this->validator->validate([
            'start' => 'bankai'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingTime10() {
        $this->validator->validate([
            'start' => 42
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingTime11() {
        $this->validator->validate([
            'start' => '20:44:09.07258'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingTime12() {
        $this->validator->validate([
            'start' => '200:44:09'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingTime13() {
        $this->validator->validate([
            'start' => '20:440:09'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingTime14() {
        $this->validator->validate([
            'start' => '20:44:090'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingTime15() {
        $this->validator->validate([
            'start' => '20:44:9'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingTime16() {
        $this->validator->validate([
            'start' => '20:4:09'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingTime17() {
        $this->validator->validate([
            'start' => '2:44:09'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingTime18() {
        $this->validator->validate([
            'start' => '20:4:9'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingTime19() {
        $this->validator->validate([
            'start' => '2:44:9'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingTime20() {
        $this->validator->validate([
            'start' => '2:4:09'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingTime21() {
        $this->validator->validate([
            'start' => '2:4:9'
        ]);

        $this->assertTrue($this->validator->failed());
    }

    public function testFailingTimeList() {
        $this->validator2->validate([
            'starts' => ['20:44:09', 2018, '05:03:30']
        ]);

        $this->assertTrue($this->validator2->failed());
    }
}
?>