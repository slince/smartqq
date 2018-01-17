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

class Recent
{
    /**
     * 好友会话.
     *
     * @var int
     */
    const TYPE_FRIEND = 0;

    /**
     * 群会话.
     *
     * @var int
     */
    const TYPE_GROUP = 1;

    /**
     * 讨论组会话.
     *
     * @var int
     */
    const TYPE_DISCUSS = 2;

    /**
     * 会话类型.
     *
     * @var int
     */
    protected $type;

    /**
     * 对方编号.
     *
     * @var int
     */
    protected $uin;

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getUin()
    {
        return $this->uin;
    }

    /**
     * @param int $uin
     */
    public function setUin($uin)
    {
        $this->uin = $uin;
    }

    /**
     * 是否是好友会话.
     *
     * @return bool
     */
    public function isFriendType()
    {
        return $this->type == static::TYPE_FRIEND;
    }

    /**
     * 是否是群会话.
     *
     * @return bool
     */
    public function isGroupType()
    {
        return $this->type == static::TYPE_GROUP;
    }

    /**
     * 是否是讨论组会话.
     *
     * @return bool
     */
    public function isDiscussType()
    {
        return $this->type == static::TYPE_DISCUSS;
    }
}
