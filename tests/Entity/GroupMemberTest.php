<?php

namespace Slince\SmartQQ\Tests\Entity;

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

        $member->setFlag(20);
        $member->setNick('foo');
        $member->setProvince('foo');
        $member->setGender('male');
        $member->setCountry('zh');
        $member->setCity('foo');
        $member->setCard('bar');
        $member->setIsVip(true);
        $member->setVipLevel(6);

        $this->assertEquals(20, $member->getFlag());
        $this->assertEquals('foo', $member->getNick());
        $this->assertEquals('foo', $member->getProvince());
        $this->assertEquals('male', $member->getGender());
        $this->assertEquals('zh', $member->getCountry());
        $this->assertEquals('foo', $member->getCity());
        $this->assertEquals('bar', $member->getCard());
        $this->assertTrue($member->isVip());
        $this->assertEquals(6, $member->getVipLevel());
    }
}