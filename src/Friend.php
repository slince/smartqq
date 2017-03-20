<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ;

class Friend
{
    /**
     * flag,作用不明
     * @var int
     */
    protected $flag;

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
    protected $status;

    public function __construct($uin, $qq, $isVip = 0, $vipLevel = 0, $flag = 0, Category $category = null)
    {
        $this->uin = $uin;
        $this->qq = $qq;
        $this->isVip = $isVip;
        $this->vipLevel = $vipLevel;
        $this->category = $category;
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