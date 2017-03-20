<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Entity;

class GroupMember
{
    /**
     * 昵称
     * @var string
     */
    protected $nick;

    /**
     * 省
     * @var string
     */
    protected $province;

    /**
     * 性别
     * @var string
     */
    protected $gender;

    /**
     * 编号
     * @var int
     */
    protected $uin;

    /**
     * 国家
     * @var string
     */
    protected $country;

    /**
     * 城市
     * @var string
     */
    protected $city;

    /**
     * 群名片
     * @var string
     */
    protected $card;

    /**
     * 是否是vip
     * @var string
     */
    protected $isVip;

    /**
     * vip等级
     * @var int
     */
    protected $vipLevel;
}