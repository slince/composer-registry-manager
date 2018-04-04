<?php

/*
 * This file is part of the slince/composer-registry-manager package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Slince\Crm\Exception;

class RegistryNotExistsException extends InvalidArgumentException
{
    public function __construct($name)
    {
        parent::__construct(sprintf("Registry [%s] does not exist", $name));
    }
}
