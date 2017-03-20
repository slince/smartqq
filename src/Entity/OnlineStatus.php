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
     * @var string
     */
    protected $status;

    public function __construct($status)
    {
        $this->status = $status;
    }

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