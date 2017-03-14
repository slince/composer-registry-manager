<?php
/**
 * CRM library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Crm\Command;

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
        $this->getManager()->dumpRepositoriesToFile($this->getRepositoriesConfigFile());

        $output->write(PHP_EOL);
        $output->writeln("<info>Remove registry [{$registryName}] success</info>");
    }
}