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

use Slince\Crm\Repository;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListCommand extends Command
{
    protected $input;

    protected $output;

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('repo:ls')
            ->setDescription('List all available repositories');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
        $this->showAllRepositories();
    }

    protected function showAllRepositories()
    {
        $currentRepository = $this->repositoryManager->getCurrentComposerRepository();
        //find all registry records
        $rows = array_map(function (Repository $repository) use ($currentRepository) {
            if ($currentRepository === $repository) {
                return [
                    '<info>*</info>',
                    "<info>{$repository->getName()}</info>",
                    "<info>{$repository->getUrl()}</info>",
                ];
            } else {
                return [
                    '',
                    $repository->getName(),
                    $repository->getUrl(),
                ];
            }
        }, $this->repositoryManager->getRepositories()->all());
        $table = new Table($this->output);
        $table->setRows($rows);
        $table->setStyle('compact');
        $table->render();
    }
}