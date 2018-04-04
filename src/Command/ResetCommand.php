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

use Slince\Crm\ConfigPath;
use Slince\Crm\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class ResetCommand extends Command
{
    /**
     * Command name
     * @var string
     */
    const NAME = 'reset';

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName(static::NAME)
            ->setDescription('Reset registry configurations');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $question = new ConfirmationQuestion("Confirm to reset repository configurations? ", false);
        $output->write(PHP_EOL);
        if (!$this->getHelper('question')->ask($input, $output, $question)) {
            return;
        }
        Utils::getFilesystem()->copy(ConfigPath::getDefaultConfigFile(), ConfigPath::getUserConfigFile(), true);

        $output->writeln("<info>Reset registry configurations success</info>");
    }
}
