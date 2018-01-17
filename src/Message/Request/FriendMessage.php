<?php
/*
 * This file is part of the slince/smartqq package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slince\SmartQQ\Message\Request;

use Slince\SmartQQ\Entity\User;

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
