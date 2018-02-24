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

use Slince\SmartQQ\Message\Message as BaseMessage;
use Slince\SmartQQ\Message\Content;

class Message extends BaseMessage
{
    /**
     * 发送时间，时间戳.
     *
     * @var int
     */
    protected $time;

    /**
     * 消息类型，作用不明.
     *
     * @var int
     */
    protected $msgType = 0;

    /**
     * Message constructor.
     *
     * @param Content $content 消息内容
     * @param int     $time    发信时间
     * @param int     $msgId   消息id
     * @param int     $msgType 消息类型
     */
    public function __construct(Content $content, $time, $msgId, $msgType)
    {
        $this->time = $time;
        $this->msgType = $msgType;
        parent::__construct($content, $msgId);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->content->getContent();
    }

    /**
     * @param int $msgType
     */
    public function setMsgType($msgType)
    {
        $this->msgType = $msgType;
    }

    /**
     * @param int $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * @return int
     */
    public function getMsgType()
    {
        return $this->msgType;
    }

    /**
     * @return int
     */
    public function getTime()
    {
        return $this->time;
    }
}
