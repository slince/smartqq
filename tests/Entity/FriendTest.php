<?php

namespace Slince\SmartQQ\Tests\Entity;

use Slince\SmartQQ\Entity\Category;
use Slince\SmartQQ\Entity\Friend;

class FriendTest extends UserTestCase
{
    public function testSet()
    {
        $friend = new Friend();
        $this->assertNull($friend->getFlag());
        $this->assertNull($friend->getFace());
        $this->assertNull($friend->getNick());
        $this->assertNull($friend->getQq());
        $this->assertNull($friend->isVip());
        $this->assertNull($friend->getVipLevel());
        $this->assertNull($friend->getCategory());
        $this->assertNull($friend->getMarkName());

        $friend->setFlag(123);
        $friend->setFace(123);
        $friend->setNick('foo');
        $friend->setQq(111222);
        $friend->setIsVip(true);
        $friend->setVipLevel(6);
        $friend->setCategory(Category::createMyFriendCategory());
        $friend->setMarkName('bar');

        $this->assertEquals('123', $friend->getFlag());
        $this->assertEquals('123', $friend->getFace());
        $this->assertEquals('foo', $friend->getNick());
        $this->assertEquals('111222', $friend->getQq());
        $this->assertTrue($friend->isVip());
        $this->assertInstanceOf(Category::class, $friend->getCategory());
        $this->assertEquals('bar', $friend->getMarkName());
    }
}