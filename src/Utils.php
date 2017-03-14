<?php
/**
 * CRM library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Crm;

use Symfony\Component\Filesystem\Filesystem;

class Utils
{
    /**
     * @var Filesystem
     */
    protected static $filesystem;

    /**
     * @return Filesystem
     */
    public static function getFilesystem()
    {
        if (is_null(static::$filesystem)) {
            static::$filesystem = new Filesystem();
        }
        return static::$filesystem ;
    }
}