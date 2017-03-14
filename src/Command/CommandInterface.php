<?php
/**
 * CRM library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Crm\Command;

use Slince\Crm\Manager;

interface CommandInterface
{
    /**
     * Get manager instance
     * @return Manager
     */
    public function getManager();
}
