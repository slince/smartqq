<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Entity;

class GroupDetail
{
    /**
     * 组id
     * @var int
     */
    protected $gid;

    /**
     * 群名称
     * @var string
     */
    protected $name;

    /**
     * code
     * @var string
     */
    protected $code;

    /**
     * 创建者的编号
     * @var int
     */
    protected $owner;

    /**
     * 群等级
     * @var int
     */
    protected $level;

    /**
     * 创建时间
     * @var int
     */
    protected $createTime;

    /**
     * flag
     * @var int
     */
    protected $flag;

    /**
     * 群公告
     * @var string
     */
    protected $memo;
}