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

use Slince\Crm\ConfigPath;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RemoveCommand extends Command
{
    /**
     * Command name
     * @var string
     */
    const NAME = 'remove';

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName(static::NAME)
            ->setDescription('Delete one custom registry')
            ->addArgument('registry-name', InputArgument::REQUIRED, 'The registry name you want remove');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $registryName = $input->getArgument('registry-name');
        //Remove registry & dump to config file
        $this->getManager()->removeRegistry($registryName);
        $this->getManager()->dumpRepositoriesToFile(ConfigPath::getUserConfigFile());

        $output->writeln("<info>Remove registry [{$registryName}] success</info>");
    }
}
