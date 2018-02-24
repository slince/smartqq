<?php

namespace Slince\SmartQQ\Tests\Message\Request;

use PHPUnit\Framework\TestCase;
use Slince\SmartQQ\Entity\Discuss;
use Slince\SmartQQ\Message\Request\DiscussMessage;

class DiscussMessageTest extends TestCase
{
    public function testDiscuss()
    {
        $foo = new Discuss();
        $foo->setId('123');
        $message = new DiscussMessage($foo, 'hello');
        $this->assertInstanceOf(Discuss::class, $message->getDiscuss());
        $this->assertEquals(123, $message->getDiscuss()->getId());

        $bar = new Discuss();
        $bar->setId('456');
        $message->setDiscuss($bar);
        $this->assertEquals(456, $message->getDiscuss()->getId());
    }
}