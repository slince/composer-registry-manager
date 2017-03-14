<?php
namespace Slince\Crm\Tests\Command;

use Slince\Crm\Command\Command;
use Slince\Crm\Manager;
use Slince\Crm\Registry;
use Slince\Crm\Utils;
use Symfony\Component\Console\Tester\CommandTester;

class CommandTestCase extends \PHPUnit_Framework_TestCase
{
    protected function createCommandTester(Command $command)
    {
        return new CommandTester($command);
    }

    protected function runCommandTester(Command $command, $arguments, $options = [])
    {
        $commandTester = new CommandTester($command);
        $commandTester->execute($arguments, $options);
        return $commandTester->getDisplay();
    }

    public function setUp()
    {
        $command = new Command(new Manager(), 'foo');
        $filesystem = Utils::getFilesystem();
        $filesystem->copy($command->getDefaultRepositoriesConfigFile(), $command->getRepositoriesConfigFile(), true);
    }

    public function tearDown()
    {
        $manager = new Manager();
        $manager->useRegistry(Registry::create([
            'name' => 'composer',
            'url' => 'https://packagist.org'
        ]));
    }
}
