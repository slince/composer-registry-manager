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

class Utils
{
    /**
     * read json file data.
     *
     * @param $file
     *
     * @return mixed
     *
     * @throws \Exception
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
}
