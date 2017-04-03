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
     * @var Group
     */
    protected $group;

    public function __construct(Group $group, $content)
    {
        $this->group = $group;
        parent::__construct($content);
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
