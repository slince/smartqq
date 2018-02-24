<?php

namespace Slince\SmartQQ\Tests\Message\Request;

use PHPUnit\Framework\TestCase;
use Slince\SmartQQ\Message\Content;
use Slince\SmartQQ\Message\Request\Message;

class MessageTest extends TestCase
{
    public function testFace()
    {
        $message = new Message('foo');
        $this->assertEquals(522, $message->getFace());
        $message->setFace(523);
        $this->assertEquals(523, $message->getFace());
    }

    public function testConstruct()
    {
        $message = new Message('foo');
        $this->assertInstanceOf(Content::class, $message->getContent());
        $this->assertGreaterThan(0, $message->getMsgId());
    }
}