<?php
/**
 * CRM library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Crm;

use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Application extends BaseApplication
{
    /**
     * Application name
     * @var string
     */
    const NAME = 'Composer Registry Manager';

    /**
     * @var RegistryManager
     */
    protected $manager;

    public function __construct(RegistryManager $manager = null)
    {
        $this->manager = $manager ?: new RegistryManager();
        parent::__construct(static::NAME);
    }

    public function run(InputInterface $input = null, OutputInterface $output = null)
    {
        $this->initializeConfigFile();
        return parent::run($input, $output);
    }

    protected function initializeConfigFile()
    {
        if (!file_exists(ConfigPath::getUserConfigFile())) {
            Utils::getFilesystem()->copy(ConfigPath::getDefaultConfigFile(), ConfigPath::getUserConfigFile());
        }
        $this->manager->readRegistriesFromFile(ConfigPath::getUserConfigFile());
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultCommands()
    {
        return array_merge([
            new Command\ListCommand($this->manager),
            new Command\UseCommand($this->manager),
            new Command\AddCommand($this->manager),
            new Command\RemoveCommand($this->manager),
            new Command\ResetCommand($this->manager),
        ], parent::getDefaultCommands());
    }
}
