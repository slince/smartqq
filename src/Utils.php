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

use Symfony\Component\Filesystem\Filesystem;

class Utils
{
    /**
     * @var Filesystem
     */
    protected static $filesystem;

    /**
     * Get filesystem.
     *
     * @return Filesystem
     */
    public static function getFilesystem()
    {
        if (is_null(static::$filesystem)) {
            static::$filesystem = new Filesystem();
        }

        return static::$filesystem;
    }

    /**
     * hash.
     *
     * @param int    $uin
     * @param string $ptWebQQ
     *
     * @return string
     */
    public static function hash($uin, $ptWebQQ)
    {
        $x = array(
            0, $uin >> 24 & 0xff ^ 0x45,
            0, $uin >> 16 & 0xff ^ 0x43,
            0, $uin >> 8 & 0xff ^ 0x4f,
            0, $uin & 0xff ^ 0x4b,
        );
        for ($i = 0; $i < 64; ++$i) {
            $x[($i & 3) << 1] ^= ord(substr($ptWebQQ, $i, 1));
        }
        $hex = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F');
        $hash = '';
        for ($i = 0; $i < 8; ++$i) {
            $hash .= $hex[$x[$i] >> 4 & 0xf].$hex[$x[$i] & 0xf];
        }

        return $hash;
    }

    /**
     * 生成ptqrtoken的哈希函数.
     *
     * @param string $string
     *
     * @return int
     */
    public static function hash33($string)
    {
        $e = 0;
        $n = strlen($string);
        for ($i = 0; $n > $i; ++$i) {
            //64位php才进行32位转换
            if (PHP_INT_MAX > 2147483647) {
                $e = static::toUint32val($e);
            }
            $e += ($e << 5) + static::charCodeAt($string, $i);
        }

        return 2147483647 & $e;
    }

    /**
     * 入转换为32位无符号整数，若溢出，则只保留低32位.
     *
     * @see http://outofmemory.cn/code-snippet/18291/out-switch-32-place-sign-integer-spill-maintain-32-place
     *
     * @param mixed $var
     *
     * @return float|int|string
     */
    public static function toUint32val($var)
    {
        if (is_string($var)) {
            if (PHP_INT_MAX > 2147483647) {
                $var = intval($var);
            } else {
                $var = floatval($var);
            }
        }
        if (!is_int($var)) {
            $var = intval($var);
        }
        if ((0 > $var) || ($var > 4294967295)) {
            $var &= 4294967295;
            if (0 > $var) {
                $var = sprintf('%u', $var);
            }
        }

        return $var;
    }

    /**
     * 计算字符的unicode，类似js中charCodeAt
     * [Link](http://www.phpjiayuan.com/90/225.html).
     *
     * @param string $str
     * @param int    $index
     *
     * @return null|number
     */
    public static function charCodeAt($str, $index)
    {
        $char = mb_substr($str, $index, 1, 'UTF-8');
        if (mb_check_encoding($char, 'UTF-8')) {
            $ret = mb_convert_encoding($char, 'UTF-32BE', 'UTF-8');

            return hexdec(bin2hex($ret));
        } else {
            return null;
        }
    }

    /**
     * 获取当前时间的毫秒数.
     *
     * @return float
     */
    public static function getMillisecond()
    {
        list($s1, $s2) = explode(' ', microtime());

        return (float) sprintf('%.0f', (floatval($s1) + floatval($s2)) * 1000);
    }

    /**
     * 用于发送消息时生成msg id.
     *
     * @return int
     */
    public static function makeMsgId()
    {
        static $sequence = 0;
        static $t = 0;
        if (!$t) {
            $t = static::getMillisecond();
            $t = ($t - $t % 1000) / 1000;
            $t = $t % 10000 * 10000;
        }
        //获取msgId
        ++$sequence;

        return $t + $sequence;
    }
}
