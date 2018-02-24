<?php

namespace Slince\SmartQQ\Tests\Entity;

use PHPUnit\Framework\TestCase;
use Slince\SmartQQ\Entity\Group;

class GroupTest extends TestCase
{
    public function testSetter()
    {
        $group = new Group();
        $this->assertNull($group->getId());
        $this->assertNull($group->getName());
        $this->assertNull($group->getCode());
        $this->assertNull($group->getFlag());
        $this->assertNull($group->getMarkName());

        $group->setId(1);
        $group->setName('foo');
        $group->setCode(111222);
        $group->setFlag(2);
        $group->setMarkName('bar');

        $this->assertEquals(1, $group->getId());
        $this->assertEquals('foo', $group->getName());
        $this->assertEquals(111222, $group->getCode());
        $this->assertEquals(2, $group->getFlag());
        $this->assertEquals('bar', $group->getMarkName());
    }
}