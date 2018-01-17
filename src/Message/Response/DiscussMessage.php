<?php
/*
 * This file is part of the slince/smartqq package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slince\SmartQQ\Message\Response;

use Slince\SmartQQ\Message\Content;

class DiscussMessage extends Message
{
    /**
     * 接收用户编号，也是QQ号.
     *
     * @var int
     */
    protected $toUin;

    /**
     * 讨论组编号.
     *
     * @var int
     */
    protected $fromUin;

    /**
     * 讨论组编号，同fromUin
     * PS: 对应影响中的did.
     *
     * @var int
     */
    protected $discussId;

    /**
     * 发信用户编号，非QQ号.
     *
     * @var int
     */
    protected $sendUin;

    public function __construct($toUin, $fromUin, $discussId, $sendUin, Content $content, $time, $msgId = 0, $msgType = 0)
    {
        $this->toUin = $toUin;
        $this->fromUin = $fromUin;
        $this->discussId = $discussId;
        $this->sendUin = $sendUin;
        parent::__construct($content, $time, $msgId, $msgType);
    }

    /**
     * @param int $toUin
     */
    public function setToUin($toUin)
    {
        $this->toUin = $toUin;
    }

    /**
     * @param int $fromUin
     */
    public function setFromUin($fromUin)
    {
        $this->fromUin = $fromUin;
    }

    /**
     * @param int $discussId
     */
    public function setDiscussId($discussId)
    {
        $this->discussId = $discussId;
    }

    /**
     * @param int $sendUin
     */
    public function setSendUin($sendUin)
    {
        $this->sendUin = $sendUin;
    }

    /**
     * @return int
     */
    public function getToUin()
    {
        return $this->toUin;
    }

    /**
     * @return int
     */
    public function getFromUin()
    {
        return $this->fromUin;
    }

    /**
     * @return int
     */
    public function getDiscussId()
    {
        return $this->discussId;
    }

    /**
     * @return int
     */
    public function getSendUin()
    {
        return $this->sendUin;
    }
}
