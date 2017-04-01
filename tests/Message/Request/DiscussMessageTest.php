<?php
namespace Slince\SmartQQ\Tests\Message\Request;

use PHPUnit\Framework\TestCase;
use Slince\SmartQQ\Entity\Discuss;
use Slince\SmartQQ\Entity\Friend;
use Slince\SmartQQ\Message\Request\DiscussMessage;
use Slince\SmartQQ\Message\Request\FriendMessage;

class DiscussMessageTest extends TestCase
{
    public function testDiscuss()
    {
        $foo = new Discuss();
        $foo->setDid('123');
        $message = new DiscussMessage($foo, 'hello');
        $this->assertInstanceOf(Discuss::class, $message->getUser());
        $this->assertEquals(123, $message->getUser()->getUin());

        $bar = new Friend();
        $bar->setUin('456');
        $message->setUser($bar);
        $this->assertEquals(456, $message->getUser()->getUin());
    }
}