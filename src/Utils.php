<?php

/*
 * This file is part of the slince/composer-registry-manager package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Slince\Crm;

final class Utils
{
    /**
     * Read json file data.
     *
     * @param string $file
     *
     * @return array
     */
    public static function readJsonFile($file)
    {
        if (!is_file($file)) {
            throw new \InvalidArgumentException(sprintf('File [%s] does not exists', $file));
        }
        $rawContent = @file_get_contents($file);
        $data = json_decode($rawContent, true);
        if (json_last_error()) {
            throw new \InvalidArgumentException(sprintf('File [%s] must contain valid json, error: %s', $file, json_last_error_msg()));
        }
        return $data;
    }

    /**
     * Get default config json file.
     *
     * @return string
     */
    public static function getDefaultConfigFile()
    {
        return __DIR__.'/../crm.default.json';
    }
}