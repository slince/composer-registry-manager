<?php
/**
 * CRM library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Crm;

use Slince\Crm\Exception\InvalidArgumentException;
use Slince\Crm\Exception\RegistryNotExistsException;

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
        if (!is_file($file)) {
            throw new InvalidArgumentException(sprintf("File [%s] does not exists", $file));
        }
        $content = @file_get_contents($file);
        $registriesData = json_decode($content, true);
        if (json_last_error()) {
            $errorMessage = json_last_error_msg();
            throw new InvalidArgumentException(sprintf("File [%s] must contain valid json, error: %s", $file, $errorMessage));
        }
        $this->registries = RegistryCollection::createFromArray($registriesData);
    }

    /**
     * Dump all registries to file
     * @param $file
     */
    public function dumpRepositories($file)
    {
        $registries = $this->registries->toArray();
        Utils::getFilesystem()->dumpFile($file, json_encode($registries));
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
     * @param $name
     * @param $url
     */
    public function addRegistry($name, $url)
    {
        $registry = Registry::create([
            'name' => $name,
            'url' => $url
        ]);
        $this->registries->add($registry);
    }

    /**
     * Make change registry command string
     * @param $name
     * @return string
     */
    public function makeChangeRegistryCommand($name)
    {
        $command = "composer config -g repo.packagist composer %s";
        $registryUrl = $this->findRegistry($name)->getUrl();
        return sprintf($command, $registryUrl);
    }

    /**
     *  Make view registry command string
     * @return string
     */
    public function makeViewCurrentRegistryCommand()
    {
        return "composer config -g repo.packagist";
    }

    /**
     * Find registry
     * @param $name
     * @return Registry
     * @throws RegistryNotExistsException
     */
    protected function findRegistry($name)
    {
        $targetRegistry = null;
        foreach ($this->registries as $registryName => $registry) {
            if (strcasecmp($name, $registryName) == 0) {
                return $registry;
            }
        }
        throw new RegistryNotExistsException($name);
    }
}