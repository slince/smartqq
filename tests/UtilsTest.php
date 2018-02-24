<?php

namespace Slince\SmartQQ\Tests;

use PHPUnit\Framework\TestCase;
use Slince\SmartQQ\Utils;
use Symfony\Component\Filesystem\Filesystem;

class UtilsTest extends TestCase
{
    public function testGetFilesystem()
    {
        $this->assertInstanceOf(Filesystem::class, Utils::getFilesystem());
    }

    public function testHash()
    {
        $uin = 1234;
        $ptWebQQ = 'bar';
        $this->assertEquals('62456143724B0099', Utils::hash($uin, $ptWebQQ));
    }

    public function testHash33()
    {
        $string = 'Qjy*mWVaseiG-qeonlAXEtSvIMfHFWHB*0QN*Axsf6AZ*xWL6uDJ*WEGSl0YJhJM';
        $this->assertEquals(1264130581, Utils::hash33($string));
    }

    public function testCharCodeAt()
    {
        $string = 'foo';
        $this->assertEquals(102, Utils::charCodeAt($string, 0));
    }

    public function testGetCurrentMillisecond()
    {
        $this->assertNotEmpty(Utils::getMillisecond());
    }

    public function testMakeMsgId()
    {
        $this->assertNotEmpty(Utils::makeMsgId());
    }
}