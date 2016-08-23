<?php
/**
 * Slince SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Model;

/**
 * Class Recent
 * @package Slince\SmartQQ\Model
 * @property int $uin
 * @property int $type
 */
class Recent extends Model
{
    const TYPE_FRIEND = 0;

    const TYPE_GROUP = 1;

    const TYPE_DISCUS = 2;
}
