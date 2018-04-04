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
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

class RemoveCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('repo:remove')
            ->setDescription('Remove a repository')
            ->addArgument('repository-name', InputArgument::OPTIONAL, 'The repository name you want to remove');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $repositoryName = $input->getArgument('repository-name');
        //auto select
        if (is_null($repositoryName)) {
            $helper = $this->getHelper('question');
            $question = new ChoiceQuestion(
                'Please select repository your want to remove',
                array_map(function (Repository $repository) {
                    return $repository->getName();
                }, $this->repositoryManager->getRepositories()->all())
            );
            $question->setErrorMessage('repository %s is invalid.');
            $repositoryName = $helper->ask($input, $output, $question);
        }
        //Remove registry & dump to config file
        $this->repositoryManager->removeRepository($repositoryName);

        $output->writeln("<info>Remove registry [{$repositoryName}] success</info>");
    }
}