<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
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
     * Get filesystem
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
     * hash
     * @param int $uin
     * @param string $ptWebQQ
     * @return string
     */
    public static function hash($uin, $ptWebQQ)
    {
        $x = array(
            0, $uin >> 24 & 0xff ^ 0x45,
            0, $uin >> 16 & 0xff ^ 0x43,
            0, $uin >>  8 & 0xff ^ 0x4f,
            0, $uin       & 0xff ^ 0x4b,
        );
        for ($i = 0; $i < 64; ++$i) {
            $x[($i & 3) << 1] ^= ord(substr($ptWebQQ, $i, 1));
        }
        $hex = array('0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F');
        $hash = '';
        for ($i = 0; $i < 8; ++$i) {
            $hash .= $hex[$x[$i] >> 4 & 0xf] . $hex[$x[$i] & 0xf];
        }
        return $hash;
    }
}