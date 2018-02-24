<?php

namespace Slince\SmartQQ\Tests\Message;

use PHPUnit\Framework\TestCase;
use Slince\SmartQQ\Message\Content;
use Slince\SmartQQ\Message\Message;
use Slince\SmartQQ\Message\MessageInterface;

class MessageTest extends TestCase
{
    public function testGetter()
    {
        $message = new Message(new Content('foo'), 10);
        $this->assertInstanceOf(Content::class, $message->getContent());
        $this->assertEquals('foo', $message->getContent()->getContent());
        $this->assertEquals(10, $message->getMsgId());
    }

    public function testSetter()
    {
        $message = new Message(new Content('foo'), 10);
        $message->setContent(new Content('bar'));
        $message->setMsgId(12);
        $this->assertEquals('bar', $message->getContent()->getContent());
        $this->assertEquals(12, $message->getMsgId());
    }

    public function testImplement()
    {
        $message = new Message(new Content('foo'), 10);
        $this->assertInstanceOf(MessageInterface::class, $message);
        $this->assertTrue(is_a($message, MessageInterface::class));
        $this->assertTrue(is_subclass_of($message, MessageInterface::class));
    }
}