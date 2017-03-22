<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Entity;

class Friend
{
    /**
     * flag,作用不明
     * @var int
     */
    protected $flag;

    /**
     * face,作用不明
     * @var int
     */
    protected $face;

    /**
     * 昵称
     * @var string
     */
    protected $nick;

    /**
     * 用户QQ号
     * @var int
     */
    protected $qq;

    /**
     * 用户编号
     * @var int
     */
    protected $uin;

    /**
     * 是否是VIP
     * @var boolean
     */
    protected $isVip;

    /**
     * VIP等级
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
     * @var string
     */
    protected $status;

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
    public function getUin()
    {
        return $this->uin;
    }

    /**
     * @return int
     */
    public function getQq()
    {
        return $this->qq;
    }

    /**
     * @return boolean
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
     * @param int $uin
     */
    public function setUin($uin)
    {
        $this->uin = $uin;
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
     * @param boolean $isVip
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

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
}