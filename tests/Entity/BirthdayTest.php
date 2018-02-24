<?php

namespace Slince\SmartQQ\Tests\Entity;

use PHPUnit\Framework\TestCase;
use Slince\SmartQQ\Entity\Birthday;

class BirthdayTest extends TestCase
{
    public function testGetter()
    {
        $birthday = new Birthday(2017, 03, 28);
        $this->assertEquals(2017, $birthday->getYear());
        $this->assertEquals(03, $birthday->getMonth());
        $this->assertEquals(28, $birthday->getDay());
    }

    public function testSetter()
    {
        $birthday = new Birthday(2017, 03, 28);
        $birthday->setYear(2018);
        $birthday->setMonth(04);
        $birthday->setDay(29);
        $this->assertEquals(2018, $birthday->getYear());
        $this->assertEquals(04, $birthday->getMonth());
        $this->assertEquals(29, $birthday->getDay());
    }
}