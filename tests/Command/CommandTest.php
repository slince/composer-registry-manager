<?php
namespace Slince\Crm\Tests\Command;

use Slince\Crm\Command\Command;
use Slince\Crm\Manager;

class CommandTest extends \PHPUnit_Framework_TestCase
{
    protected function createCommand()
    {
        $manager = new Manager();
        return new Command($manager, 'foo');
    }

    public function testGetManager()
    {
        $command = $this->createCommand();
        $this->assertInstanceOf(Manager::class, $command->getManager());
    }

    public function testGetConfigFile()
    {
        $command = $this->createCommand();
        $configFile = $command->getRepositoriesConfigFile();
        $this->assertFileExists($configFile);
    }

    public function testGetDefaultConfigFile()
    {
        $command = $this->createCommand();
        $configFile = $command->getDefaultRepositoriesConfigFile();
        $this->assertFileExists($configFile);
    }
}