<?php
/**
 * Slince SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Model;

/**
 * 字体
 * @package Slince\SmartQQ\Model
 * @property string $name
 * @property int $size
 * @property array $style
 * @property string $color
 * @method getName
 * @method getColor
 * @method getStyle
 * @method getSize
 */
class Font extends Model
{
    /**
     * 创建默认字体
     * @return Font
     */
    static function makeDefaultFont()
    {
        return new Font([
            'name' => '宋体',
            'size'=> 10,
            'style'=> [0, 0, 0],
            'color' => '000000'
        ]);
    }
}