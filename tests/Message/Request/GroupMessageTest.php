<?php

namespace Slince\SmartQQ\Tests\Message\Request;

use PHPUnit\Framework\TestCase;
use Slince\SmartQQ\Entity\Group;
use Slince\SmartQQ\Message\Request\GroupMessage;

class GroupMessageTest extends TestCase
{
    public function testDiscuss()
    {
        $foo = new Group();
        $foo->setId('123');
        $message = new GroupMessage($foo, 'hello');
        $this->assertInstanceOf(Group::class, $message->getGroup());
        $this->assertEquals(123, $message->getGroup()->getId());

        $bar = new Group();
        $bar->setId('456');
        $message->setGroup($bar);
        $this->assertEquals(456, $message->getGroup()->getId());
    }
}