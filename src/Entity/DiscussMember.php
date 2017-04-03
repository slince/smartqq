<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Entity;

class DiscussMember extends User
{
    /**
     * @var string
     */
    protected $nick;

    /**
     * @var int
     */
    protected $clientType;

    /**
     * @var string
     */
    protected $status;

    /**
     * 作用不明
     * @var int
     */
    protected $ruin;

    /**
     * @return string
     */
    public function getNick()
    {
        return $this->nick;
    }

    /**
     * @param string $nick
     */
    public function setNick($nick)
    {
        $this->nick = $nick;
    }

    /**
     * @return int
     */
    public function getClientType()
    {
        return $this->clientType;
    }

    /**
     * @param int $clientType
     */
    public function setClientType($clientType)
    {
        $this->clientType = $clientType;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getRuin()
    {
        return $this->ruin;
    }

    /**
     * @param int $ruin
     */
    public function setRuin($ruin)
    {
        $this->ruin = $ruin;
    }
}
