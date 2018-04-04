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

use Slince\Crm\Registry;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

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
        parent::configure();
        $this->setName(static::NAME)
            ->setDescription('Change current registry')
            ->addArgument('registry-name', InputArgument::OPTIONAL, 'The registry name you want use');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $registryName = $input->getArgument('registry-name');
        //auto select
        if (is_null($registryName)) {
            $helper = $this->getHelper('question');
            $question = new ChoiceQuestion(
                'Please select your favorite registry (defaults to composer)',
                array_map(function (Registry $registry) {
                    return $registry->getName();
                }, $this->getManager()->getRegistries()->all()),
                0
            );
            $question->setErrorMessage('Registry %s is invalid.');
            $registryName = $helper->ask($input, $output, $question);
        }

        $registry = $this->getManager()->findRegistry($registryName);
        $this->getManager()->useRegistry($registry, $this->checkIsCurrent($input));

        $output->writeln("<info>Use registry [{$registryName}] success</info>");
    }
}
