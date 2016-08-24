<?php
/**
 * Slince SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Model;

class Model implements ModelInterface
{
    /**
     * 属性
     * @var array
     */
    protected $attributes = [];

    public function __construct(array $attributes = [])
    {
        if (!empty($attributes)) {
            $this->attributes = $attributes;
        }
    }

    public function __get($name)
    {
        return $this->get($name);
    }

    public function __set($name, $value)
    {
        $this->set($name, $value);
    }

    /**
     * @param array $attributes
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * 输出数组形式
     * @return array
     */
    public function toArray()
    {
        return $this->attributes;
    }

    /**
     * 设置单个属性值
     * @param $attribute
     * @param $value
     */
    public function set($attribute, $value)
    {
        $this->attributes[$attribute] = $value;
    }

    /**
     * 获取属性值
     * @param $attribute
     * @return null
     */
    public function get($attribute)
    {
        return $this->attributes[$attribute] ?: null;
    }

    /**
     * 继承方法
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->attributes;
    }
}
