<?php

namespace Slince\SmartQQ\Tests\Message;

use PHPUnit\Framework\TestCase;
use Slince\SmartQQ\Message\Content;
use Slince\SmartQQ\Message\Font;

class ContentTest extends TestCase
{
    public function testGetter()
    {
        $content = new Content('foo', Font::createDefault());
        $this->assertEquals('foo', $content->getContent());
        $this->assertInstanceOf(Font::class, $content->getFont());
    }

    public function testSetter()
    {
        $content = new Content('foo', Font::createDefault());
        $content->setContent('bar');
        $content->setFont(new Font('simsun', 'ffffff', 20, [20, 30, 40]));
        $this->assertEquals('bar', $content->getContent());
        $this->assertEquals('simsun', $content->getFont()->getName());
    }

    public function testToString()
    {
        $content = new Content('foo', Font::createDefault());
        $json = '["foo", ["font", {"name":"微软雅黑","color":"000000","size":"10","style":[10, 10, 10]}]]';
        $this->assertEquals(\GuzzleHttp\json_decode($json), \GuzzleHttp\json_decode(strval($content)));
    }
}