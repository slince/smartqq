<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Message;

abstract class AbstractMessage implements MessageInterface
{
    /**
     * 消息类型
     * @var string
     */
    protected $type;

    /**
     * @var Content
     */
    protected $content;

    /**
     * 发送时间，时间戳
     * @var int
     */
    protected $time;

    /**
     * 消息id
     * @var int
     */
    protected $msgId;

    /**
     * 消息类型，作用不明
     * @var int
     */
    protected $msgType = 0;

    /**
     * AbstractMessage constructor.
     * @param string $type
     * @param Content $content 消息内容
     * @param int $time 发信时间
     * @param int $msgId 消息id
     * @param int $msgType 消息类型
     */
    public function __construct($type, Content $content, $time, $msgId, $msgType)
    {
        $this->type = $type;
        $this->content = $content;
        $this->msgId = $msgId;
        $this->msgType = $msgType;
    }

    /**
     * 获取消息类型
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param Content $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @param int $msgId
     */
    public function setMsgId($msgId)
    {
        $this->msgId = $msgId;
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
     * @return Content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return int
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @return int
     */
    public function getMsgId()
    {
        return $this->msgId;
    }

    /**
     * @return int
     */
    public function getMsgType()
    {
        return $this->msgType;
    }
}