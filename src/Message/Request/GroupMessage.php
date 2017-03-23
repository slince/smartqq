<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Message\Request;

use Slince\SmartQQ\Entity\Group;
use Slince\SmartQQ\Message\Content;

class GroupMessage extends Message
{
    /**
     * 群编号
     * @var int
     */
    protected $groupUin;

    /**
     * @var Group
     */
    protected $group;

    public function __construct($groupUin, Content $content)
    {
        $this->groupUin = $groupUin;
        parent::__construct($content);
    }

    /**
     * @return int
     */
    public function getGroupUin()
    {
        return $this->groupUin;
    }

    /**
     * @param int $groupUin
     */
    public function setGroupUin($groupUin)
    {
        $this->groupUin = $groupUin;
    }

    /**
     * @return Group
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param Group $group
     */
    public function setGroup($group)
    {
        $this->group = $group;
    }
}