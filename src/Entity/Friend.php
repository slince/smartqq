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

class Friend extends User
{
    /**
     * flag,作用不明.
     *
     * @var int
     */
    protected $flag;

    /**
     * face,作用不明.
     *
     * @var int
     */
    protected $face;

    /**
     * 昵称.
     *
     * @var string
     */
    protected $nick;

    /**
     * 用户QQ号.
     *
     * @var int
     */
    protected $qq;

    /**
     * 是否是VIP.
     *
     * @var bool
     */
    protected $isVip;

    /**
     * VIP等级.
     *
     * @var int
     */
    protected $vipLevel;

    /**
     * @var Category
     */
    protected $category;

    /**
     * @var string
     */
    protected $markName;

    /**
     * @param string $markName
     */
    public function setMarkName($markName)
    {
        $this->markName = $markName;
    }

    /**
     * @return string
     */
    public function getMarkName()
    {
        return $this->markName;
    }

    /**
     * @return int
     */
    public function getQq()
    {
        return $this->qq;
    }

    /**
     * @return bool
     */
    public function isVip()
    {
        return $this->isVip;
    }

    /**
     * @return int
     */
    public function getVipLevel()
    {
        return $this->vipLevel;
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return int
     */
    public function getFlag()
    {
        return $this->flag;
    }

    /**
     * @return int
     */
    public function getFace()
    {
        return $this->face;
    }

    /**
     * @param int $face
     */
    public function setFace($face)
    {
        $this->face = $face;
    }

    /**
     * @return string
     */
    public function getNick()
    {
        return $this->nick;
    }

    /**
     * @param string $nick
     */
    public function setNick($nick)
    {
        $this->nick = $nick;
    }

    /**
     * @param int $qq
     */
    public function setQq($qq)
    {
        $this->qq = $qq;
    }

    /**
     * @param int $flag
     */
    public function setFlag($flag)
    {
        $this->flag = $flag;
    }

    /**
     * @param bool $isVip
     */
    public function setIsVip($isVip)
    {
        $this->isVip = $isVip;
    }

    /**
     * @param int $vipLevel
     */
    public function setVipLevel($vipLevel)
    {
        $this->vipLevel = $vipLevel;
    }

    /**
     * @param Category $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }
}
