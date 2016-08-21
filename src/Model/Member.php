<?php
/**
 * Slince SmartQQ Library
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