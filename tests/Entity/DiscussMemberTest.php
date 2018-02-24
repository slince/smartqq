<?php

namespace Slince\SmartQQ\Tests\Entity;

use Slince\SmartQQ\Entity\DiscussMember;

class DiscussMemberTest extends UserTestCase
{
    public function testSetter()
    {
        $member = new DiscussMember();
        $this->assertNull($member->getNick());
        $this->assertNull($member->getRuin());
        $this->assertNull($member->getStatus());
        $this->assertNull($member->getClientType());
        $member->setNick('foo');
        $member->setStatus('online');
        $member->setClientType(1);
        $member->setRuin(123);
        $this->assertEquals('foo', $member->getNick());
        $this->assertEquals('online', $member->getStatus());
        $this->assertEquals(1, $member->getClientType());
        $this->assertEquals(123, $member->getRuin());
    }
}