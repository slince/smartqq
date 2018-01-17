<?php
/*
 * This file is part of the slince/smartqq package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slince\SmartQQ\Entity;

/**
 * QQ好友分组.
 */
class Category
{
    /**
     * 分组名称.
     *
     * @var string
     */
    protected $name;

    /**
     * 编号,作用不明.
     *
     * @var int
     */
    protected $index;

    /**
     * 顺序.
     *
     * @var int
     */
    protected $sort;

    public function __construct($name, $index = 0, $sort = 0)
    {
        $this->name = $name;
        $this->index = $index;
        $this->sort = $sort;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param int $index
     */
    public function setIndex($index)
    {
        $this->index = $index;
    }

    /**
     * @param mixed $sort
     */
    public function setSort($sort)
    {
        $this->sort = $sort;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * @return mixed
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * 创建我的好友默认分类.
     *
     * @return Category
     */
    public static function createMyFriendCategory()
    {
        return new static('我的好友', 0, 0);
    }
}
