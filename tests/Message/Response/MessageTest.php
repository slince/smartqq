<?php

namespace Slince\SmartQQ\Tests\Message\Response;

use PHPUnit\Framework\TestCase;
use Slince\SmartQQ\Message\Content;
use Slince\SmartQQ\Message\Response\Message;

class MessageTest extends TestCase
{
    public function testGetter()
    {
        $now = time();
        $message = new Message(new Content('foo'), $now, 100, 123);
        $this->assertInstanceOf(Content::class, $message->getContent());
        $this->assertEquals('foo', $message->getContent()->getContent());
        $this->assertEquals($now, $message->getTime());
        $this->assertEquals(100, $message->getMsgId());
        $this->assertEquals(123, $message->getMsgType());
    }

    public function testSetter()
    {
        $now = time();
        $message = new Message(new Content('foo'), $now, 100, 123);

        $yesterday = strtotime('-1 day');
        $message->setContent(new Content('bar'));
        $message->setTime($yesterday);
        $message->setMsgId(200);
        $message->setMsgType(456);

        $this->assertEquals('bar', $message->getContent()->getContent());
        $this->assertEquals($yesterday, $message->getTime());
        $this->assertEquals(200, $message->getMsgId());
        $this->assertEquals(456, $message->getMsgType());
    }

    public function testToString()
    {
        $now = time();
        $message = new Message(new Content('foo'), $now, 100, 123);
        $this->assertEquals('foo', (string) $message);
    }

    public function testSearchFace()
    {
        $this->assertEquals(14, Content::searchFaceId('微笑'));
        $this->assertEquals('微笑', Content::searchFaceText(14));
    }
}