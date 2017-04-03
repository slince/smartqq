<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Message;

interface MessageInterface
{
    /**
     * 消息类型，好友消息
     * @var string
     */
    const TYPE_FRIEND = 'message';

    /**
     * 消息类型，群消息
     * @var string
     */
    const TYPE_GROUP = 'group_message';

    /**
     * 消息类型，讨论组消息，
     * PS: discu接口返回该值，非故意拼错
     * @var string
     */
    const TYPE_DISCUSS = 'discu_message';

    /**
     * 获取消息内容
     * @return Content
     */
    public function getContent();
}
