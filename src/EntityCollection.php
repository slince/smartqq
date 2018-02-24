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

use Cake\Collection\Collection;

class EntityCollection extends Collection
{
    /**
     * 根据实体属性筛选指定一个实体.
     *
     * @param $attributeName
     * @param $attributeValue
     *
     * @return object|null
     */
    public function firstByAttribute($attributeName, $attributeValue)
    {
        $callback = function($entity) use ($attributeName, $attributeValue) {
            $method = 'get'.ucfirst($attributeName);

            return $entity->$method() == $attributeValue;
        };

        return  $this->filter($callback)->first();
    }
}
