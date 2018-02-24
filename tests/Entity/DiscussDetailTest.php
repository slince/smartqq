<?php

namespace Slince\SmartQQ\Tests\Entity;

use PHPUnit\Framework\TestCase;
use Slince\SmartQQ\Entity\DiscussDetail;
use Slince\SmartQQ\EntityCollection;

class DiscussDetailTest extends TestCase
{
    public function testSetter()
    {
        $detail = new DiscussDetail();
        $this->assertNull($detail->getDid());
        $this->assertNull($detail->getName());
        $this->assertNull($detail->getMembers());
        $detail->setDid(1);
        $detail->setName('foo');
        $detail->setMembers(new EntityCollection([]));
        $this->assertEquals(1, $detail->getDid());
        $this->assertEquals('foo', $detail->getName());
        $this->assertNotNull($detail->getMembers());
    }
}