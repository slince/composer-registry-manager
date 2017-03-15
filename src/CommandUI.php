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
use Slince\Crm\Console\Application;

class CommandUI
{
    /**
     * Creates all commands
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
     * Application entry
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
