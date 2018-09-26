<?php
/*
 * This file is part of the slince/smartqq package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slince\SmartQQ\Entity;

use Slince\SmartQQ\EntityCollection;

class DiscussDetail
{
    /**
     * @var int
     */
    protected $did;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var EntityCollection|DiscussMember[]
     */
    protected $members;

    /**
     * @return int
     */
    public function getDid()
    {
        return $this->did;
    }

    /**
     * @param int $did
     */
    public function setDid($did)
    {
        $this->did = $did;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * 获取讨论组成员
     *
     * @return EntityCollection|DiscussMember[]
     */
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * @param EntityCollection $members
     */
    public function setMembers($members)
    {
        $this->members = $members;
    }
}
