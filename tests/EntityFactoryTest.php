<?php

namespace Slince\SmartQQ\Tests;

use PHPUnit\Framework\TestCase;
use Slince\SmartQQ\EntityFactory;

class EntityFactoryTest extends TestCase
{
    public function testCreateEntity()
    {
        $foo = EntityFactory::createEntity(FooEntity::class, [
            'name' => 'bar',
        ]);
        $this->assertInstanceOf(FooEntity::class, $foo);
        $this->assertEquals('bar', $foo->getName());
    }

    public function testCreateEntities()
    {
        $dataArray = [
            [
                'name' => 'foo',
            ],
            [
                'name' => 'bar',
            ],
            [
                'name' => 'baz',
            ],
        ];
        $entities = EntityFactory::createEntities(FooEntity::class, $dataArray);
        $this->assertEquals(3, count($entities));
        $this->assertEquals('foo', $entities[0]->getName());
        $this->assertEquals('bar', $entities[1]->getName());
        $this->assertEquals('baz', $entities[2]->getName());
    }
}