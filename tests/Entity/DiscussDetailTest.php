<?php
namespace Slince\SmartQQ\Tests\Entity;

use PHPUnit\Framework\TestCase;
use Slince\SmartQQ\Entity\DiscussDetail;
use Slince\SmartQQ\EntityCollection;

class DiscussDetailTest extends TestCase
{
    public function testSetter()
    {
        $discuss = new DiscussDetail();
        $this->assertNull($discuss->getDid());
        $this->assertNull($discuss->getName());
        $this->assertNull($discuss->getMembers());
        $discuss->setDid(1);
        $discuss->setName('foo');
        $discuss->setMembers(new EntityCollection([]));
        $this->assertEquals(1, $discuss->getDid());
        $this->assertEquals('foo', $discuss->getName());
        $this->assertNotNull($discuss->getMembers());
    }
}