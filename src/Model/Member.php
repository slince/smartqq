<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Model;

/**
 * Class Member
 * @package Slince\SmartQQ\Model
 * @property int $uin
 * @property int $nickname
 * @property string $status
 * @property int $clientType
 *
 * @property string $account QQ号
 * @property string $markname 备注名
 * @property boolean $isVip
 * @property int $vipLevel
 * @property Category $category //所属分组
 * @property Profile $profile //详细信息
 */
class Member extends Model
{
    /**
     * 在线
     * @var string
     */
    const STATUS_ONLINE = 'online';

    /**
     * 离线
     * @var string
     */
    const STATUS_OFFLINE = 'offline';
}
