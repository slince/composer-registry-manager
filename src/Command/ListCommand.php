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
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListCommand extends Command
{
    /**
     * Command name
     * @var string
     */
    const NAME = 'ls';

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        parent::configure();
        $this->setName(static::NAME)
            ->setDescription("List all available registries");
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $currentRegistry = $this->getManager()->getCurrentRegistry($this->checkIsCurrent($input));
        $registries = $this->getManager()->getRegistries();

        //find all registry records
        $rows = array_map(function (Registry $registry) use ($currentRegistry) {
            if ($currentRegistry == $registry) {
                return [
                    '<info>*</info>',
                    "<info>{$registry->getName()}</info>",
                    "<info>{$registry->getUrl()}</info>"
                ];
            } else {
                return [
                    '',
                    $registry->getName(),
                    $registry->getUrl()
                ];
            }
        }, $registries->all());
        $this->outputResult($rows, $output);
    }

    /**
     * Output table
     * @param $rows
     * @param OutputInterface $output
     */
    protected function outputResult($rows, OutputInterface $output)
    {
        $table = new Table($output);
        $table->setRows($rows);
        $table->setStyle('compact');
        $table->render();
    }
}
