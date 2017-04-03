<?php
namespace Slince\SmartQQ\Tests\Entity;

use PHPUnit\Framework\TestCase;
use Slince\SmartQQ\Entity\OnlineStatus;
use Slince\SmartQQ\Exception\InvalidArgumentException;

class OnlineStatusTest extends TestCase
{
    public function testSetter()
    {
        $onlineStatus = new OnlineStatus();
        $this->assertNull($onlineStatus->getStatus());
        $this->assertNull($onlineStatus->getUin());
        $this->assertNull($onlineStatus->getClientType());

        $onlineStatus->setStatus(OnlineStatus::ONLINE);
        $onlineStatus->setUin(123);
        $onlineStatus->setClientType(1);

        $this->assertEquals(123, $onlineStatus->getUin());
        $this->assertEquals(OnlineStatus::ONLINE, $onlineStatus->getStatus());
        $this->assertEquals(1, $onlineStatus->getClientType());
    }

    public function testToString()
    {
        $onlineStatus = new OnlineStatus();
        $onlineStatus->setStatus(OnlineStatus::ONLINE);
        $this->assertEquals(OnlineStatus::ONLINE, strval($onlineStatus));
    }

    public function testSetWrongStatus()
    {
        $onlineStatus = new OnlineStatus();
        $this->setExpectedException(InvalidArgumentException::class);
        $onlineStatus->setStatus('invalid_status');
    }
}