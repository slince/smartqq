<?php

namespace Slince\SmartQQ\Tests\Message;

use PHPUnit\Framework\TestCase;
use Slince\SmartQQ\Message\MessageInterface;

class MessageInterfaceTest extends TestCase
{
    public function testMethod()
    {
        $message = $this->getMockBuilder(MessageInterface::class)->getMock();
        $this->assertTrue(method_exists($message, 'getContent'));
    }
}