<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Message;

abstract class Message implements MessageInterface
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
     * 消息id
     * @var int
     */
    protected $msgId;

    /**
     * AbstractMessage constructor.
     * @param string $type
     * @param Content $content 消息内容
     * @param int $msgId 消息id
     */
    public function __construct($type, Content $content, $msgId)
    {
        $this->type = $type;
        $this->content = $content;
        $this->msgId = $msgId;
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
     * @return Content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return int
     */
    public function getMsgId()
    {
        return $this->msgId;
    }
}