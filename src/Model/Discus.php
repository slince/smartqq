<?php
/**
 * Slince SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Model;

/**
 * Class Discus
 * @package Slince\SmartQQ\Model
 * @property int $id
 * @property string $name
 */
class Discus extends Model
{
    /**
     * 讨论组会员
     * @var Member[]
     */
    protected $members = [];

    /**
     * 所有会员
     * @return Member[]
     */
    function getMembers()
    {
        return $this->members;
    }
}