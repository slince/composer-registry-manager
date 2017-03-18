<?php
/**
 * CRM library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Crm;

use Slince\Crm\Exception\InvalidArgumentException;
use Slince\Crm\Exception\RegistryNotExistsException;
use Slince\Crm\Exception\RuntimeException;

class Manager
{
    /**
     * registry collection
     * @var RegistryCollection
     */
    protected $registries;

    public function __construct()
    {
        $this->registries = new RegistryCollection();
    }

    /**
     * Read repositories from file
     * @param $file
     */
    public function readRegistriesFromFile($file)
    {
        $this->registries = RegistryCollection::createFromArray(Utils::readJsonFile($file));
    }

    /**
     * Dump all registries to file
     * @param $file
     */
    public function dumpRepositoriesToFile($file)
    {
        $registries = $this->registries->toArray();
        Utils::getFilesystem()->dumpFile($file, json_encode($registries, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    /**
     * @return RegistryCollection
     */
    public function getRegistries()
    {
        return $this->registries;
    }

    /**
     * Add one registry
     * @param string $name
     * @param string $url
     * @throws InvalidArgumentException
     * @return Registry
     */
    public function addRegistry($name, $url)
    {
        try {
            $this->findRegistry($name);
            throw new InvalidArgumentException(sprintf("Registry [%s] already exists", $name));
        } catch (RegistryNotExistsException $exception) {
            $registry = Registry::create([
                'name' => $name,
                'url' => $url
            ]);
            $this->registries->add($registry);
        }
        return $registry;
    }

    /**
     * Remove registry
     * @param string $name
     */
    public function removeRegistry($name)
    {
        try {
            $registry = $this->findRegistry($name);
            $this->registries->remove($registry);
        } catch (RegistryNotExistsException $exception) {
        }
    }

    /**
     * Find registry
     * @param $name
     * @return Registry
     * @throws RegistryNotExistsException
     */
    public function findRegistry($name)
    {
        foreach ($this->registries as $registry) {
            if (strcasecmp($name, $registry->getName()) == 0) {
                return $registry;
            }
        }
        throw new RegistryNotExistsException($name);
    }

    /**
     * Use Registry
     * @param Registry $registry
     * @param boolean $isCurrent
     * @return void
     */
    public function useRegistry(Registry $registry, $isCurrent = false)
    {
        $command = $this->makeUseRegistryCommand($registry, $isCurrent);
        $this->runSystemCommand($command);
    }

    /**
     * Get Current Registry
     * @param boolean $isCurrent
     * @throws RuntimeException
     * @return Registry
     */
    public function getCurrentRegistry($isCurrent = false)
    {
        $rawOutput = $this->runSystemCommand($isCurrent
            ? "composer config repo.packagist.org"
            : "composer config -g repo.packagist.org"
        );
        $registryData = json_decode($rawOutput, true);
        if (json_last_error()) {
            throw new RuntimeException(sprintf("Can not find current registry, error: %s", json_last_error_msg()));
        }
        foreach ($this->registries as $registry) {
            if (strcasecmp($registry->getUrl(), $registryData['url']) == 0) {
                return $registry;
            }
        }
        return Registry::create([
            'url' => $registryData['url'],
            'name' => 'unknown'
        ]);
    }

    /**
     * Make change registry command string
     * @param Registry $registry
     * @param boolean $isCurrent
     * @return string
     */
    protected function makeUseRegistryCommand(Registry $registry, $isCurrent)
    {
        $command = $isCurrent
            ? "composer config repo.packagist composer %s"
            : "composer config -g repo.packagist composer %s";
        return sprintf($command, $registry->getUrl());
    }

    /**
     * Run command
     * @param $command
     * @return string
     */
    protected function runSystemCommand($command)
    {
        return exec($command);
    }
}
