<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Entity;

class Discuss
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
}