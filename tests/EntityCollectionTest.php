<?php

namespace Slince\SmartQQ\Tests;

use PHPUnit\Framework\TestCase;
use Slince\SmartQQ\EntityCollection;
use Slince\SmartQQ\EntityFactory;

class EntityCollectionTest extends TestCase
{
    public function testFirstFilterByProperty()
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
        $collection = new EntityCollection(EntityFactory::createEntities(FooEntity::class, $dataArray));
        $this->assertEquals('foo', $collection->firstByAttribute('name', 'foo')->getName());
    }
}