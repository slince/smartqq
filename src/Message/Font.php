<?php
/*
 * This file is part of the slince/smartqq package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slince\SmartQQ\Message;

class Font
{
    /**
     * 名称.
     *
     * @var string
     */
    protected $name;

    /**
     * 颜色.
     *
     * @var string
     */
    protected $color;

    /**
     * 字号.
     *
     * @var string
     */
    protected $size;

    /**
     * 风格，具体不知效果.
     *
     * @var string
     */
    protected $style;

    public function __construct($name, $color, $size, array $style = [])
    {
        $this->name = $name;
        $this->color = $color;
        $this->size = $size;
        $this->style = $style;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param string $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     * @param string $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @param string $style
     */
    public function setStyle($style)
    {
        $this->style = $style;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return string
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * 转换成数组.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'name' => $this->name,
            'size' => $this->size,
            'style' => $this->style,
            'color' => $this->color,
        ];
    }

    /**
     * 创建一个默认字体.
     *
     * @return static
     */
    public static function createDefault()
    {
        return new static('微软雅黑', '000000', 10, [0, 0, 0]);
    }
}
