<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ;

class Credential
{
    /**
     * 鉴权参数ptwebqq，存储在cookie中
     * @var string
     */
    protected $ptWebQQ;

    /**
     * 鉴权参数vfwebqq
     * @var string
     */
    protected $vfWebQQ;

    /**
     * 鉴权参数pSessionId
     * @var string
     */
    protected $pSessionId;

    /**
     * 客户端id
     * @var int
     */
    protected $clientId = 5399199;

    /**
     * 当前登录的用户编号（o+QQ号）
     * @var string
     */
    protected $uin;
}