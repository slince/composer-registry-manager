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
     * @var string
     */
    const VERSION = '1.2.0';

    /**
     * Application name
     * @var string
     */
    const NAME = 'Composer Registry Manager %s by Tao and contributors.';

    protected static $logo = <<<EOT
 _____   _____        ___  ___  
/  ___| |  _  \      /   |/   | 
| |     | |_| |     / /|   /| | 
| |     |  _  /    / / |__/ | | 
| |___  | | \ \   / /       | | 
\_____| |_|  \_\ /_/        |_| 


EOT;

    /**
     * @var RegistryManager
     */
    protected $manager;

    public function __construct(RegistryManager $manager = null)
    {
        $this->manager = $manager ?: new RegistryManager();
        parent::__construct(sprintf(static::NAME, static::VERSION));
    }

    /**
     * {@inheritdoc}
     * @codeCoverageIgnore
     */
    public function run(InputInterface $input = null, OutputInterface $output = null)
    {
        $this->initializeConfigFile();
        return parent::run($input, $output);
    }

    /**
     * @codeCoverageIgnore
     */
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
    public function getHelp()
    {
        return static::$logo . parent::getHelp();
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
