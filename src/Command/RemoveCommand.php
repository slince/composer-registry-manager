<?php

/*
 * This file is part of the slince/composer-repository-manager package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Slince\Crm\Command;

use Slince\Crm\ConfigPath;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RemoveCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('repo:remove')
            ->setDescription('Remove a repository')
            ->addArgument('repository-name', InputArgument::REQUIRED, 'The repository name you want to remove');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $registryName = $input->getArgument('repository-name');
        //Remove registry & dump to config file
        $this->repositoryManager->removeRepository($registryName);

        $output->writeln("<info>Remove registry [{$registryName}] success</info>");
    }
}