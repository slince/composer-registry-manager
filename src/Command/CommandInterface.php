<?php
/**
 * CRM library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Crm\Command;

use Slince\Crm\RegistryManager;

interface CommandInterface
{
    /**
     * Get manager instance
     * @return RegistryManager
     */
    public function getManager();
}
