<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ;

use Cake\Collection\Collection;

class EntityCollection extends Collection
{
    /**
     * 根据实体属性筛选指定一个实体
     * @param $attributeName
     * @param $attributeValue
     * @return Object|null
     */
    public function firstByAttribute($attributeName, $attributeValue)
    {
        $callback = function ($entity) use ($attributeName, $attributeValue) {
            $method = 'get' . ucfirst($attributeName);
            return $entity->$method() == $attributeValue;
        };
        return  $this->filter($callback)->first();
    }
}
