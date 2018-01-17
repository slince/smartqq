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

use Slince\SmartQQ\Entity\Group;

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
