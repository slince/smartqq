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

use Slince\SmartQQ\EntityCollection;

class GroupDetail
{
    /**
     * 组id.
     *
     * @var int
     */
    protected $gid;

    /**
     * 群名称.
     *
     * @var string
     */
    protected $name;

    /**
     * code.
     *
     * @var string
     */
    protected $code;

    /**
     * 创建者的编号.
     *
     * @var int
     */
    protected $owner;

    /**
     * 群等级.
     *
     * @var int
     */
    protected $level;

    /**
     * 创建时间.
     *
     * @var int
     */
    protected $createTime;

    /**
     * flag.
     *
     * @var int
     */
    protected $flag;

    /**
     * 群公告.
     *
     * @var string
     */
    protected $memo;

    /**
     * @var EntityCollection
     */
    protected $members;

    /**
     * @return int
     */
    public function getGid()
    {
        return $this->gid;
    }

    /**
     * @param int $gid
     */
    public function setGid($gid)
    {
        $this->gid = $gid;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return int
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param int $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param int $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * @return int
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * @param int $createTime
     */
    public function setCreateTime($createTime)
    {
        $this->createTime = $createTime;
    }

    /**
     * @return int
     */
    public function getFlag()
    {
        return $this->flag;
    }

    /**
     * @param int $flag
     */
    public function setFlag($flag)
    {
        $this->flag = $flag;
    }

    /**
     * @return string
     */
    public function getMemo()
    {
        return $this->memo;
    }

    /**
     * @param string $memo
     */
    public function setMemo($memo)
    {
        $this->memo = $memo;
    }

    /**
     * @return EntityCollection
     */
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * @param EntityCollection $members
     */
    public function setMembers($members)
    {
        $this->members = $members;
    }
}
