<?php
/*
 * This file is part of the slince/smartqq package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slince\SmartQQ;

class EntityFactory
{
    /**
     * 创建多个实体对象
     *
     * @param $entityClass
     * @param $dataArray
     *
     * @return array
     */
    public static function createEntities($entityClass, $dataArray)
    {
        return array_map(function($data) use ($entityClass) {
            return static::createEntity($entityClass, $data);
        }, $dataArray);
    }

    /**
     * 创建实体对象
     *
     * @param $entityClass
     * @param $data
     *
     * @return object
     */
    public static function createEntity($entityClass, $data)
    {
        $entity = new $entityClass();
        static::applyProperties($entity, $data);

        return $entity;
    }

    /**
     * 设置属性参数.
     *
     * @param $entityInstance
     * @param $data
     *
     * @return object
     */
    protected static function applyProperties($entityInstance, $data)
    {
        foreach ($data as $property => $value) {
            $funcName = 'set'.ucfirst($property);
            if (method_exists($entityInstance, $funcName)) {
                $entityInstance->$funcName($value);
            }
        }

        return $entityInstance;
    }
}
