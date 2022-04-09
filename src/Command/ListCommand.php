<?php

declare(strict_types=1);

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
use Symfony\Component\Console\Input\InputOption;
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
            ->addOption('location', 'l', InputOption::VALUE_OPTIONAL, 'The location of the repository')
            ->setDescription('List all available repositories');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        // filter by location
        $location = $input->getOption('location');
        $repositories = $location
            ? $this->filterRepositoriesByLocation($location)
            : iterator_to_array($this->repositoryManager->getRepositories());

        //find all repository records
        $currentRepository = $this->repositoryManager->getCurrentComposerRepository();
        $rows = array_map(function (Repository $repository) use ($currentRepository) {
            if ($currentRepository === $repository) {
                return [
                    '<info>*</info>',
                    "<info>{$repository->getName()}</info>",
                    "<info>{$repository->getUrl()}</info>",
                    "<info>{$repository->getLocation()}</info>",
                ];
            } else {
                return [
                    '',
                    $repository->getName(),
                    $repository->getUrl(),
                    $repository->getLocation()
                ];
            }
        }, $repositories);

        $style = new SymfonyStyle($input, $output);
        $style->table([], $rows);

        return 0;
    }

    protected function filterRepositoriesByLocation(string $location): array
    {
        return array_filter(iterator_to_array($this->repositoryManager->getRepositories()),
            fn(Repository $repository) => stripos($repository->getLocation(), $location) !== false
        );
    }
}