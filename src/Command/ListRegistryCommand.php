<?php
/**
 * CRM library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Crm\Command;

use Slince\Crm\Exception\RuntimeException;
use Slince\Crm\Registry;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListRegistryCommand extends AbstractCommand
{
    /**
     * Command name
     * @var string
     */
    const NAME = 'ls';

    public function configure()
    {
        $this->setName(static::NAME)
            ->setDescription("List all available registries");
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $currentRegistryUrl = $this->findCurrentRegistryUrl();
        $registries = $this->getManager()->getRegistries();

        //find all registry records
        $rows = array_map(function(Registry $registry) use ($currentRegistryUrl){
            if ($currentRegistryUrl == $registry->getUrl()) {
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

        $output->write(PHP_EOL);
        $table->render();
    }

    /**
     * Get current registry url
     * @return string
     */
    protected function findCurrentRegistryUrl()
    {
        $rawOutput = exec($this->getManager()->makeViewCurrentRegistryCommand());
        $registry = json_decode($rawOutput, true);
        if (json_last_error()) {
            throw new RuntimeException(sprintf("Can not find current registry, error: %s", json_last_error_msg()));
        }
        return $registry['url'];
    }
}