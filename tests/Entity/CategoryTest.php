<?php

namespace Slince\SmartQQ\Tests\Entity;

use PHPUnit\Framework\TestCase;
use Slince\SmartQQ\Entity\Category;

class CategoryTest extends TestCase
{
    public function testGetter()
    {
        $category = new Category('foo', 1, 2);
        $this->assertEquals('foo', $category->getName());
        $this->assertEquals(1, $category->getIndex());
        $this->assertEquals(2, $category->getSort());
    }

    public function testSetter()
    {
        $category = new Category('foo', 1, 2);
        $category->setName('bar');
        $category->setIndex(2);
        $category->setSort(3);
        $this->assertEquals('bar', $category->getName());
        $this->assertEquals(2, $category->getIndex());
        $this->assertEquals(3, $category->getSort());
    }

    public function testCreateMyFriendCategory()
    {
        $category = Category::createMyFriendCategory();
        $this->assertEquals('我的好友', $category->getName());
        $this->assertEquals(0, $category->getIndex());
        $this->assertEquals(0, $category->getSort());
    }
}