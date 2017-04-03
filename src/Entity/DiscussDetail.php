<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
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
     * @var EntityCollection
     */
    protected $members;

    /**
     * @return mixed
     */
    public function getDid()
    {
        return $this->did;
    }

    /**
     * @param mixed $did
     */
    public function setDid($did)
    {
        $this->did = $did;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return EntityCollection
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
