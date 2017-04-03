<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Message\Request;

use Slince\SmartQQ\Entity\User;
use Slince\SmartQQ\Message\Content;

class FriendMessage extends Message
{
    /**
     * @var User
     */
    protected $user;

    public function __construct(User $user, $content)
    {
        $this->user = $user;
        parent::__construct($content);
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }
}
