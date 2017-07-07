<?php
namespace Slince\Crm\Tests\Stub;

use Slince\Crm\Registry;
use Slince\Crm\RegistryManager;

class RegistryManagerStub extends RegistryManager
{
    protected $currentRegistry;

    protected $registry;

    public function useRegistry(Registry $registry, $isCurrent = false)
    {
        if ($isCurrent) {
            $this->currentRegistry = $registry;
        } else {
            $this->registry = $registry;
        }
    }

    public function getCurrentRegistry($isCurrent = false)
    {
        return $isCurrent ? $this->currentRegistry : $this->registry;
    }
}