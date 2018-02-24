<?php

namespace Slince\SmartQQ\Tests\Message\Response;

use PHPUnit\Framework\TestCase;
use Slince\SmartQQ\Message\Content;
use Slince\SmartQQ\Message\Response\FriendMessage;

class FriendMessageTest extends TestCase
{
    public function testToUin()
    {
        $message = new FriendMessage(123, 456, new Content('foo'), time());

        $this->assertEquals(123, $message->getToUin());
        $message->setToUin(1234);
        $this->assertEquals(1234, $message->getToUin());
    }

    public function testFromUin()
    {
        $message = new FriendMessage(123, 456, new Content('foo'), time());

        $this->assertEquals(456, $message->getFromUin());
        $message->setFromUin(4567);
        $this->assertEquals(4567, $message->getFromUin());
    }
}