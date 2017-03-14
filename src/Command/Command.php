<?php
/**
 * CRM library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Crm\Command;

use Slince\Crm\Manager;
use Symfony\Component\Console\Command\Command as BaseCommand;

class Command extends BaseCommand implements CommandInterface
{
    /**
     * @var Manager
     */
    protected $manager;

    public function __construct(Manager $manager, $name = null)
    {
        $this->manager = $manager;
        $this->manager->readRegistriesFromFile($this->getRepositoriesConfigFile());
        parent::__construct($name);
    }

    /**
     * @param Manager $manager
     */
    public function setManager($manager)
    {
        $this->manager = $manager;
    }

    /**
     * {@inheritdoc}
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * Get config json file
     * @return string
     */
    public function getRepositoriesConfigFile()
    {
        return __DIR__ . '/../../crm.json';
    }

    /**
     * Get default config json file
     * @return string
     */
    public function getDefaultRepositoriesConfigFile()
    {
        return __DIR__ . '/../../crm.default.json';
    }
}
