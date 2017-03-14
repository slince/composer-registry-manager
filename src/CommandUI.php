<?php
/**
 * CRM library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Crm;

use Slince\Crm\Command\ListRegistryCommand;
use Symfony\Component\Console\Application;

class CommandUI
{
    /**
     * 创建command
     * @return array
     */
    static function createCommands()
    {
        $manager = new Manager();
        return [
            new ListRegistryCommand($manager),
        ];
    }

    /**
     * command应用主入口
     * @throws \Exception
     */
    static function main()
    {
        $application = new Application();
        $application->addCommands(self::createCommands());
        $application->setAutoExit(true);
        $application->run();
    }
}