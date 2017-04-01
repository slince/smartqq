<?php

namespace Slince\SmartQQ\Tests\Entity;

use PHPUnit\Framework\TestCase;

class UserTestCase extends TestCase
{
    public function testUin()
    {
        if (!preg_match('#(\w+)Test$#', get_class($this), $matches)) {
            return false;
        }
        $className = "\\Slince\\SmartQQ\\Entity\\{$matches[1]}";
        $user = new $className();
        $this->assertNull($user->getUin());
        $user->setUin(123);
        $this->assertEquals(123, $user->getUin());
    }
}