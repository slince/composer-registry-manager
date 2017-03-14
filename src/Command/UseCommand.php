<?php
/**
 * CRM library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Crm\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UseCommand extends Command
{
    /**
     * Command name
     * @var string
     */
    const NAME = 'use';

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName(static::NAME)
            ->setDescription('Change current registry to registry')
            ->addArgument('registry-name', InputArgument::REQUIRED, 'The registry name you want use');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $registryName = $input->getArgument('registry-name');
        $registry = $this->getManager()->findRegistry($registryName);
        $this->getManager()->useRegistry($registry);

        $output->write(PHP_EOL);
        $output->writeln("<info>Use registry [{$registryName}] success</info>");
    }
}