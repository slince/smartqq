<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Message\Request;

use Slince\SmartQQ\Message\Content;

class DiscussMessage extends Message
{
    /**
     * 讨论组编号
     * @var int
     */
    protected $discussId;

    public function __construct($discussId, Content $content)
    {
        $this->discussId = $discussId;
        parent::__construct($content);
    }
}