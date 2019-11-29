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

use Slince\Crm\Repository;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

class UseCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        parent::configure();
        $this->setName('repo:use')
            ->setDescription('Change current repository')
            ->addArgument('repository-name', InputArgument::OPTIONAL, 'The repository name you want to use')
            ->addOption('current', 'c', InputOption::VALUE_NONE, 'Change repository for current project');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $style = new SymfonyStyle($input, $output);
        $repositoryName = $input->getArgument('repository-name');
        //auto select
        if (is_null($repositoryName)) {
            $question = new ChoiceQuestion(
                'Please select your favorite repository (defaults to composer)',
                array_map(function (Repository $repository) {
                    return $repository->getName();
                }, $this->repositoryManager->getRepositories()->all()),
                0
            );
            $question->setErrorMessage('The repository %s is invalid.');
            $repositoryName = $style->askQuestion($question);
        }

        $repository = $this->repositoryManager->getRepositories()->search($repositoryName);

        $this->repositoryManager->useRepository($repository, $input->getOption('current'));

        $style->success("Use the repository [{$repositoryName}] successfully");
    }
}