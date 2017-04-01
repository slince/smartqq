<?php
namespace Slince\SmartQQ\Tests\Entity;

use PHPUnit\Framework\TestCase;

class UserTestCase extends TestCase
{
    public function testUin()
    {
		if (!preg_match('#/(\w+)Test$#', get_class($this), $matches)) {
			return false;
		}
		
		
		var_dump($matches);
		
		
		
		var_dump(strstr(get_class($this), 'Tests', true));
        $user = new $className();
        $this->assertNull($user->getUin());
        $user->serUin(123);
        $this->assertEquals(123, $user->getUin());
    }
}