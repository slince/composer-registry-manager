<?php
namespace Slince\Crm\Tests\Stub;

use Slince\Crm\Repository;
use Slince\Crm\RegistryManager;

class RegistryManagerStub extends RegistryManager
{
    protected $currentRegistry;

    protected $registry;

    public function useRegistry(Repository $registry, $isCurrent = false)
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