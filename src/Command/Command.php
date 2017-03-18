<?php
/**
 * CRM library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Crm\Command;

use Slince\Crm\Exception\RuntimeException;
use Slince\Crm\Manager;
use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;

class Command extends BaseCommand implements CommandInterface
{
    /**
     * @var Manager
     */
    protected $manager;

    /**
     * composer.json
     * @var string
     */
    protected $composerFileName = 'composer.json';

    public function __construct(Manager $manager, $name = null)
    {
        $this->manager = $manager;
        $this->manager->readRegistriesFromFile($this->getRepositoriesConfigFile());
        parent::__construct($name);
    }

    public function configure()
    {
        $this->addOption('current', 'c', InputOption::VALUE_NONE, 'Manage the current config file');
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

    /**
     * Is global mode
     * @param InputInterface $input
     * @throws RuntimeException
     * @return bool
     */
    public function checkIsCurrent(InputInterface $input)
    {
        $isCurrentMode = $input->getOption('current');
        if ($isCurrentMode) {
            $composerJson = getcwd() . DIRECTORY_SEPARATOR . $this->composerFileName;
            if (!file_exists($composerJson)) {
                throw new RuntimeException("Crm could not find a composer.json file");
            }
        }
        return $isCurrentMode;
    }

    /**
     * @param string $composerFileName
     */
    public function setComposerFileName($composerFileName)
    {
        $this->composerFileName = $composerFileName;
    }

    /**
     * @return string
     */
    public function getComposerFileName()
    {
        return $this->composerFileName;
    }
}
