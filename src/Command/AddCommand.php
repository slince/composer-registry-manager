<?php
/**
 * CRM library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Crm\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddCommand extends Command
{
    /**
     * Command name
     * @var string
     */
    const NAME = 'add';

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName(static::NAME)
            ->setDescription('Add one custom registry')
            ->addArgument('registry-name', InputArgument::REQUIRED, 'The registry name')
            ->addArgument('registry-url', InputArgument::REQUIRED, 'The registry url');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $registryName = $input->getArgument('registry-name');
        $registryUrl = $input->getArgument('registry-url');
        //Add registry & dump to config file
        $this->getManager()->addRegistry($registryName, $registryUrl);
        $this->getManager()->dumpRepositoriesToFile($this->getRepositoriesConfigFile());

        $output->write(PHP_EOL);
        $output->writeln("<info>Add registry [{$registryName}] success</info>");
    }
}
