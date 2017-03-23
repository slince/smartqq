<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Message\Request;

use Slince\SmartQQ\Entity\DiscussMember;
use Slince\SmartQQ\Entity\Friend;
use Slince\SmartQQ\Entity\GroupMember;
use Slince\SmartQQ\Message\Content;

class FriendMessage extends Message
{
    /**
     * 用户编号
     * @var int
     */
    protected $to;

    /**
     * @var Friend|GroupMember|DiscussMember
     */
    protected $toUser;

    /**
     * @return int
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param int $to
     */
    public function setTo($to)
    {
        $this->to = $to;
    }

    /**
     * @return DiscussMember|Friend|GroupMember
     */
    public function getToUser()
    {
        return $this->toUser;
    }

    /**
     * @param DiscussMember|Friend|GroupMember $toUser
     */
    public function setToUser($toUser)
    {
        $this->toUser = $toUser;
    }

    public function __construct($to, Content $content)
    {
        $this->to = $to;
        parent::__construct($content);
    }
}