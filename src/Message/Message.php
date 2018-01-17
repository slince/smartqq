<?php
/*
 * This file is part of the slince/smartqq package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slince\SmartQQ\Message;

class Message implements MessageInterface
{
    /**
     * @var Content
     */
    protected $content;

    /**
     * 消息id.
     *
     * @var int
     */
    protected $msgId;

    /**
     * AbstractMessage constructor.
     *
     * @param Content $content 消息内容
     * @param int     $msgId   消息id
     */
    public function __construct(Content $content, $msgId)
    {
        $this->content = $content;
        $this->msgId = $msgId;
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
