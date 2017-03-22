<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Entity;

class OnlineStatus
{
    /**
     * @var string
     */
    const ONLINE = 'online';

    /**
     * @var string
     */
    const OFFLINE = 'offline';

    /**
     * 用户编号
     * @var int
     */
    protected $uin;

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
     * @var string
     */
    protected $status;

    /**
     * 转换为字符串
     */
    public function __toString()
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

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
}