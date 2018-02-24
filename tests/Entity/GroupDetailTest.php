<?php

namespace Slince\SmartQQ\Tests\Entity;

use PHPUnit\Framework\TestCase;
use Slince\SmartQQ\Entity\GroupDetail;
use Slince\SmartQQ\EntityCollection;

class GroupDetailTest extends TestCase
{
    public function testSetter()
    {
        $detail = new GroupDetail();
        $this->assertNull($detail->getGid());
        $this->assertNull($detail->getName());
        $this->assertNull($detail->getCode());
        $this->assertNull($detail->getOwner());
        $this->assertNull($detail->getLevel());
        $this->assertNull($detail->getCreateTime());
        $this->assertNull($detail->getFlag());
        $this->assertNull($detail->getMemo());
        $this->assertNull($detail->getMembers());

        $detail->setGId(1);
        $detail->setName('foo');
        $detail->setCode(111222);
        $detail->setOwner(111222);
        $detail->setLevel(5);
        $detail->setCreateTime(111222);
        $detail->setFlag(2);
        $detail->setMemo('foo memo');
        $detail->setMembers(new EntityCollection([]));

        $this->assertEquals(1, $detail->getGid());
        $this->assertEquals('foo', $detail->getName());
        $this->assertEquals(111222, $detail->getCode());
        $this->assertEquals(111222, $detail->getOwner());
        $this->assertEquals(5, $detail->getLevel());
        $this->assertEquals(111222, $detail->getCreateTime());
        $this->assertEquals(2, $detail->getFlag());
        $this->assertEquals('foo memo', $detail->getMemo());
        $this->assertNotNull($detail->getMembers());
    }
}