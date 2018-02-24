<?php

namespace Slince\SmartQQ\Tests\Entity;

use PHPUnit\Framework\TestCase;
use Slince\SmartQQ\Entity\Recent;

class RecentTest extends TestCase
{
    public function testSetter()
    {
        $recent = new Recent();
        $this->assertNull($recent->getType());
        $this->assertNull($recent->getUin());
        $recent->setType(Recent::TYPE_GROUP);
        $recent->setUin(123);
        $this->assertEquals(Recent::TYPE_GROUP, $recent->getType());
        $this->assertEquals(123, $recent->getUin());
    }

    public function testIsType()
    {
        $recent = new Recent();
        $recent->setType(Recent::TYPE_GROUP);
        $this->assertTrue($recent->isGroupType());
        $recent->setType(Recent::TYPE_DISCUSS);
        $this->assertTrue($recent->isDiscussType());
        $recent->setType(Recent::TYPE_FRIEND);
        $this->assertTrue($recent->isFriendType());
    }
}