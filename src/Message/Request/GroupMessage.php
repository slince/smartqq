<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Message\Request;

use Slince\SmartQQ\Message\Content;

class GroupMessage extends Message
{
    /**
     * 群编号
     * @var int
     */
    protected $groupUin;

    public function __construct($groupUin, Content $content)
    {
        $this->groupUin = $groupUin;
        parent::__construct($content);
    }
}