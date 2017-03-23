<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Message\Request;

use Slince\SmartQQ\Message\Message as BaseMessage;
use Slince\SmartQQ\Message\Content;

class Message extends BaseMessage
{
    /**
     * 具体不明
     * @var int
     */
    protected $face;

    /**
     * 请求message的id
     * @var int
     */
    public static $msgId = 65890001;

    public function __construct(Content $content)
    {
        parent::__construct($content, static::$msgId ++);
    }

    /**
     * @param int $face
     */
    public function setFace($face)
    {
        $this->face = $face;
    }

    /**
     * @return int
     */
    public function getFace()
    {
        return $this->face;
    }
}