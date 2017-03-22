<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Entity;

class Recent
{
    /**
     * 好友会话
     * @var int
     */
    const TYPE_FRIEND = 0;

    /**
     * 群会话
     * @var int
     */
    const TYPE_GROUP = 2;

    /**
     * 讨论组会话
     * @var int
     */
    const TYPE_DISCUSS = 3;

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getUin()
    {
        return $this->uin;
    }

    /**
     * @param int $uin
     */
    public function setUin($uin)
    {
        $this->uin = $uin;
    }

    /**
     * 会话类型
     * @var int
     */
    protected $type;

    /**
     * 对方编号
     * @var int
     */
    protected $uin;
}