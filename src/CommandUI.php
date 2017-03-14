<?php
/**
 * CRM library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Crm;

use Slince\Crm\Command\AddCommand;
use Slince\Crm\Command\ListCommand;
use Slince\Crm\Command\RemoveCommand;
use Slince\Crm\Command\ResetCommand;
use Slince\Crm\Command\UseCommand;
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
            new ListCommand($manager),
            new UseCommand($manager),
            new AddCommand($manager),
            new RemoveCommand($manager),
            new ResetCommand($manager),
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