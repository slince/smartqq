<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Message\Response;

use Slince\SmartQQ\Message\Content;

class GroupMessage extends Message
{
    /**
     * 接收用户编号，也是QQ号
     * @var int
     */
    protected $toUin;
    
    /**
     * 群编号，非群号
     * @var int
     */
    protected $fromUin;

    /**
     * 群编号，非群号,同fromUin
     * @var int
     */
    protected $groupCode;

    /**
     * 发信用户编号，非QQ号
     * @var int
     */
    protected $sendUin;

    public function __construct($toUin, $fromUin, $groupCode, $sendUin, Content $content, $time, $msgId = 0, $msgType = 0)
    {
        $this->toUin = $toUin;
        $this->fromUin = $fromUin;
        $this->groupCode = $groupCode;
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
     * @param int $groupCode
     */
    public function setGroupCode($groupCode)
    {
        $this->groupCode = $groupCode;
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
    public function getGroupCode()
    {
        return $this->groupCode;
    }

    /**
     * @return int
     */
    public function getSendUin()
    {
        return $this->sendUin;
    }
}
