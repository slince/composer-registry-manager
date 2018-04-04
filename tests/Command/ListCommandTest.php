<?php
namespace Slince\Crm\Tests\Command;

use Slince\Crm\Command\ListCommand;
use Slince\Crm\Command\UseCommand;
use Slince\Crm\ConfigPath;
use Slince\Crm\RegistryManager;
use Slince\Crm\Repository;
use Slince\Crm\Exception\RuntimeException;
use Slince\Crm\Tests\Stub\RegistryManagerStub;
use Slince\Crm\Utils;

class ListCommandTest extends CommandTestCase
{
    public function testExecute()
    {
        $manager = new RegistryManagerStub();
        $manager->readRegistriesFromFile(ConfigPath::getDefaultConfigFile());
        $this->assertRegExp('#packagist\.org#', $this->runCommandTester(new ListCommand($manager), []));
    }

    public function testForCurrent()
    {
        $manager = new RegistryManagerStub();
        $manager->readRegistriesFromFile(ConfigPath::getDefaultConfigFile());
        $this->runCommandTester(new UseCommand($manager), [
            'registry-name' => 'phpcomposer',
            '--current' => true
        ]);
        $this->assertContains('* phpcomposer', $this->runCommandTester(new ListCommand($manager), [
            '--current' => true
        ]));
    }

    public function testForCurrentException()
    {
        $this->expectException(RuntimeException::class);
        $manager = new RegistryManagerStub();
        $manager->readRegistriesFromFile(ConfigPath::getDefaultConfigFile());
        $command = new UseCommand($manager);
        $command->setComposerFileName('for-test.json'); //Just for test
        $this->runCommandTester($command, [
            'registry-name' => 'phpcomposer',
            '--current' => true
        ]);
    }
}
