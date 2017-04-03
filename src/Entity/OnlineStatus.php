<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Entity;

use Slince\SmartQQ\Exception\InvalidArgumentException;

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
     * 在线类型
     * @var int
     */
    protected $clientType;

    /**
     * 用户编号
     * @var int
     */
    protected $uin;

    /**
     * @var string
     */
    protected $status;

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
        if ($status != static::ONLINE && $status != static::OFFLINE) {
            throw new InvalidArgumentException();
        }
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getClientType()
    {
        return $this->clientType;
    }

    /**
     * @param int $clientType
     */
    public function setClientType($clientType)
    {
        $this->clientType = $clientType;
    }
}
