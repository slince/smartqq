<?php
/**
 * Slince SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Model;

/**
 * Class Message
 * @package Slince\SmartQQ\Model
 * @property int $id
 * @property int $type
 *
 * @property string $time
 * @property string $content
 * @property Font $font
 * @property int $fromUin
 * @property int $toUin
 */
class Message extends Model
{
    const TYPE_FRIEND = 'message';

    const TYPE_GROUP = 'group_message';

    const TYPE_DISCUS = 'discu_message';
}
