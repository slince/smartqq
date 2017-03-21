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
}