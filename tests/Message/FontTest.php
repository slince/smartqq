<?php

namespace Slince\SmartQQ\Tests\Message;

use PHPUnit\Framework\TestCase;
use Slince\SmartQQ\Message\Font;

class FontTest extends TestCase
{
    public function testGetter()
    {
        $font = new Font('foo', '000000', 18, [30, 40, 50]);

        $this->assertEquals('foo', $font->getName());
        $this->assertEquals('000000', $font->getColor());
        $this->assertEquals(18, $font->getSize());
        $this->assertEquals([30, 40, 50], $font->getStyle());
    }

    public function testSetter()
    {
        $font = new Font('foo', '000000', 18, [30, 40, 50]);

        $font->setName('bar');
        $font->setColor('000001');
        $font->setSize(20);
        $font->setStyle([10, 10, 10]);

        $this->assertEquals('bar', $font->getName());
        $this->assertEquals('000001', $font->getColor());
        $this->assertEquals(20, $font->getSize());
        $this->assertEquals([10, 10, 10], $font->getStyle());
    }

    public function testToArray()
    {
        $font = new Font('foo', '000000', 18, [30, 40, 50]);
        $this->assertEquals([
            'name' => 'foo',
            'color' => '000000',
            'size' => 18,
            'style' => [30, 40, 50],
        ], $font->toArray());
    }

    public function testCreateDefault()
    {
        $font = Font::createDefault();
        $this->assertInstanceOf(Font::class, $font);
    }
}