<?php

/*
 * This file is part of the slince/composer-registry-manager package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Slince\Crm\Command;

use Composer\Command\BaseCommand;
use Slince\Crm\Exception\RuntimeException;
use Slince\Crm\RepositoryManager;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;

class Command extends BaseCommand
{
    /**
     * @var RepositoryManager
     */
    protected $repositoryManager;

    /**
     * composer.json
     * @var string
     */
    protected $composerFileName = 'composer.json';

    public function __construct(RepositoryManager $repositoryManager, $name = null)
    {
        $this->repositoryManager = $repositoryManager;
        parent::__construct($name);
    }

    public function configure()
    {
        $this->addOption('current', 'c', InputOption::VALUE_NONE, 'Manage the current config file');
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