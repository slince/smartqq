<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Message\Request;

use Slince\SmartQQ\Message\Message as BaseMessage;
use Slince\SmartQQ\Message\Content;
use Slince\SmartQQ\Utils;

class Message extends BaseMessage
{
    /**
     * 具体不明
     * @var int
     */
    protected $face = 522;

    public function __construct($content)
    {
        if (is_string($content)) {
            $content = new Content($content);
        }
        parent::__construct($content, Utils::makeMsgId());
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
