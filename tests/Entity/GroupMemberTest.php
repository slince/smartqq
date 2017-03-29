<?php
namespace Slince\SmartQQ\Tests\Entity;

use Slince\SmartQQ\Entity\DiscussMember;
use Slince\SmartQQ\Entity\GroupMember;

class GroupMemberTest extends UserTestCase
{
    public function testSetter()
    {
        $member = new GroupMember();
        $this->assertNull($member->getFlag());
        $this->assertNull($member->getNick());
        $this->assertNull($member->getProvince());
        $this->assertNull($member->getGender());
        $this->assertNull($member->getCountry());
        $this->assertNull($member->getCity());
        $this->assertNull($member->getCard());
        $this->assertNull($member->isVip());
        $this->assertNull($member->getVipLevel());

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