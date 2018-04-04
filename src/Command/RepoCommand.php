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

use Slince\Crm\ProxyApplication;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\DescriptorHelper;

class RepoCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('repo');
        $this->setDefinition($this->createDefinition())
        ->setDescription('Lists commands')
        ->setHelp(<<<'EOF'
The <info>%command.name%</info> command lists all commands:

  <info>php %command.full_name%</info>

You can also display the commands for a specific namespace:

  <info>php %command.full_name% test</info>

You can also output the information in other formats by using the <comment>--format</comment> option:

  <info>php %command.full_name% --format=xml</info>

It's also possible to get raw list of commands (useful for embedding command runner):

  <info>php %command.full_name% --raw</info>
EOF
        );
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = new DescriptorHelper();
        $helper->describe($output, new ProxyApplication($this->repositoryManager->getCommands()), array(
            'format' => $input->getOption('format'),
            'raw_text' => $input->getOption('raw'),
            'namespace' => 'repo',
        ));
    }

    /**
     * {@inheritdoc}
     */
    private function createDefinition()
    {
        return new InputDefinition(array(
            new InputArgument('namespace', InputArgument::OPTIONAL, 'The namespace name'),
            new InputOption('raw', null, InputOption::VALUE_NONE, 'To output raw command list'),
            new InputOption('format', null, InputOption::VALUE_REQUIRED, 'The output format (txt, xml, json, or md)', 'txt'),
        ));
    }
}