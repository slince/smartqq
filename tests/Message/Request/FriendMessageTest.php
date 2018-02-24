<?php

namespace Slince\SmartQQ\Tests\Message\Request;

use PHPUnit\Framework\TestCase;
use Slince\SmartQQ\Entity\Friend;
use Slince\SmartQQ\Message\Request\FriendMessage;

class FriendMessageTest extends TestCase
{
    public function testUser()
    {
        $foo = new Friend();
        $foo->setUin('123');
        $message = new FriendMessage($foo, 'hello');
        $this->assertInstanceOf(Friend::class, $message->getUser());
        $this->assertEquals(123, $message->getUser()->getUin());

        $bar = new Friend();
        $bar->setUin('456');
        $message->setUser($bar);
        $this->assertEquals(456, $message->getUser()->getUin());
    }
}