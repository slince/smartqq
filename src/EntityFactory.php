<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ;

use Slince\SmartQQ\Entity\Group;

class EntityFactory
{
    /**
     * @param $groupData
     * @return Group
     */
    public static function createGroup($groupData)
    {
        $group = new Group();
        static::applyProperties($group, $groupData);
        return $group;
    }

    /**
     * 设置属性参数
     * @param $entityInstance
     * @param $data
     * @return object
     */
    protected static function applyProperties($entityInstance, $data)
    {
        foreach ($data as $property => $value) {
            $funcName = 'set' . ucfirst($property);
            if (method_exists($entityInstance, $funcName)) {
                $entityInstance->$funcName($value);
            }
        }
        return $entityInstance;
    }
}