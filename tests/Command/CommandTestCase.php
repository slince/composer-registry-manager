<?php
namespace Slince\Crm\Tests\Command;

use Slince\Crm\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class CommandTestCase extends \PHPUnit_Framework_TestCase
{
    protected function runCommandTester(Command $command, $arguments, $options = [])
    {
        $commandTester = new CommandTester($command);
        $commandTester->execute($arguments, $options);
        return $commandTester->getDisplay();
    }
}
