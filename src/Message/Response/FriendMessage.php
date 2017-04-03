<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Message\Response;

use Slince\SmartQQ\Message\MessageInterface;
use Slince\SmartQQ\Message\Content;

class FriendMessage extends Message
{
    /**
     * 接收用户编号，也是QQ号
     * @var int
     */
    protected $toUin;

    /**
     * 发信用户编号，非QQ号
     * @var int
     */
    protected $fromUin;

    public function __construct($toUin, $fromUin, Content $content, $time, $msgId = 0, $msgType = 0)
    {
        $this->toUin = $toUin;
        $this->fromUin = $fromUin;
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
}
