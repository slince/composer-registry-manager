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
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ListCommand extends Command
{
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
        $currentRepository = $this->repositoryManager->getCurrentComposerRepository();
        //find all repository records
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

        $style = new SymfonyStyle($input, $output);
        $style->table([], $rows);
    }
}