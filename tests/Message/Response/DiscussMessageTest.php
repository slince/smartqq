<?php

namespace Slince\SmartQQ\Tests\Message\Response;

use PHPUnit\Framework\TestCase;
use Slince\SmartQQ\Message\Content;
use Slince\SmartQQ\Message\Response\DiscussMessage;

class DiscussMessageTest extends TestCase
{
    public function testGetter()
    {
        $message = new DiscussMessage(123, 456, 456, 789, new Content('foo'), time());

        $this->assertEquals(123, $message->getToUin());
        $this->assertEquals(456, $message->getFromUin());
        $this->assertEquals(456, $message->getDiscussId());
        $this->assertEquals(789, $message->getSendUin());
    }

    public function testSetter()
    {
        $message = new DiscussMessage(123, 456, 456, 789, new Content('foo'), time());

        $message->setToUin(1234);
        $message->setFromUin(4567);
        $message->setDiscussId(4567);
        $message->setSendUin(78910);

        $this->assertEquals(1234, $message->getToUin());
        $this->assertEquals(4567, $message->getFromUin());
        $this->assertEquals(4567, $message->getDiscussId());
        $this->assertEquals(78910, $message->getSendUin());
    }
}