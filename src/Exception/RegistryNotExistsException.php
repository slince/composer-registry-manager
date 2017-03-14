<?php
/**
 * CRM library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Crm\Exception;

class RegistryNotExistsException extends InvalidArgumentException
{
    public function __construct($name)
    {
        parent::__construct(sprintf("Registry [%s] does not exist", $name));
    }
}