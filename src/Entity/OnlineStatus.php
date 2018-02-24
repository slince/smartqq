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
     * 在线类型.
     *
     * @var int
     */
    protected $clientType;

    /**
     * 用户编号.
     *
     * @var int
     */
    protected $uin;

    /**
     * busy,away,online.
     *
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
     * 转换为字符串.
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
