<?php
namespace Slince\SmartQQ\Tests\Entity;

use PHPUnit\Framework\TestCase;

class UserTestCase extends TestCase
{
    public function testUin()
    {
        $className = str_replace(
            strstr(get_class($this), 'Test', true),
            'Tests/',
            ''
        );
        $user = new $className();
        $this->assertNull($user->getUin());
        $user->serUin(123);
        $this->assertEquals(123, $user->getUin());
    }
}