<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Entity;

class DiscussDetail
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var DiscussMember[]
     */
    protected $members;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @return DiscussMember[]
     */
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * @param DiscussMember[] $members
     */
    public function setMembers($members)
    {
        $this->members = $members;
    }
}