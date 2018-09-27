<?php

namespace Slince\SmartQQ\Tests;

use Slince\SmartQQ\Message\Response\Message;
use Slince\SmartQQ\MessageHandler;

class MessageHandlerTest extends TestCase
{
    public function testListen()
    {
        $client = $this->createClientMock('poll_messages.txt');

        $handler = new MessageHandler($client);
        $startTime = time();
        $handler->onMessage(function($message) use (&$index, $startTime, $handler){
            $this->assertInstanceOf(Message::class, $message);
            if (time() - $startTime > 1) {
                $handler->stop();
            }
        });
        $handler->listen();
    }
}