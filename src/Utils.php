<?php
/**
 * CRM library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Crm;

use Symfony\Component\Filesystem\Filesystem;
use Slince\Crm\Exception\InvalidArgumentException;

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

    /**
     * read json file data
     * @param $file
     * @return mixed
     * @throws \Exception
     */
    public static function readJsonFile($file)
    {
        if (!is_file($file)) {
            throw new InvalidArgumentException(sprintf("File [%s] does not exists", $file));
        }
        $rawContent = @file_get_contents($file);
        $data = json_decode($rawContent, true);
        if (json_last_error()) {
            throw new InvalidArgumentException(sprintf("File [%s] must contain valid json, error: %s", $file, json_last_error_msg()));
        }
        return $data;
    }
}
