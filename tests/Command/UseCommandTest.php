<?php
namespace Slince\Crm\Tests\Command;

use Slince\Crm\Application;
use Slince\Crm\Command\AddCommand;
use Slince\Crm\Command\UseCommand;
use Slince\Crm\ConfigPath;
use Slince\Crm\RegistryManager;
use Slince\Crm\Tests\Stub\RegistryManagerStub;
use Symfony\Component\Console\Tester\CommandTester;

class UseCommandTest extends CommandTestCase
{
    public function testExecute()
    {
        $manager = new RegistryManagerStub();
        $this->runCommandTester(new AddCommand($manager), [
            'registry-name' => 'foo',
            'registry-url' => 'http://foo.com',
        ]);
        $this->runCommandTester(new UseCommand($manager), [
            'registry-name' => 'foo',
        ]);
        $this->assertEquals('http://foo.com', $manager->getCurrentRegistry()->getUrl());
    }

    public function testExecuteForCurrent()
    {
        $manager = new RegistryManagerStub();
        $manager->readRegistriesFromFile(ConfigPath::getDefaultConfigFile());
        $this->runCommandTester(new AddCommand($manager), [
            'registry-name' => 'bar',
            'registry-url' => 'http://bar.com',
        ]);
        $this->runCommandTester(new UseCommand($manager), [
            'registry-name' => 'composer',
        ]);
        $this->runCommandTester(new UseCommand($manager), [
            'registry-name' => 'bar',
            '--current' => true
        ]);
        $this->assertEquals('https://packagist.org', $manager->getCurrentRegistry()->getUrl());
        $this->assertEquals('http://bar.com', $manager->getCurrentRegistry(true)->getUrl());
    }

    public function testExecuteWithoutArgumentsAndInput()
    {
        $commandTester = $this->createCommandTester();

        //If the symfony/console version is less than 3.2, the test is not performed
        if (!method_exists($commandTester, 'setInputs')) {
            return;
        }

        $commandTester->setInputs([PHP_EOL]);
        $commandTester->execute([]);
        $display = $commandTester->getDisplay();
        $this->assertContains('Please select your favorite registry', $display);
        $this->assertContains('Use registry [composer] success', $display);
    }

    public function testExecuteWithoutArguments()
    {
        $commandTester = $this->createCommandTester();

        //If the symfony/console version is less than 3.2, the test is not performed
        if (!method_exists($commandTester, 'setInputs')) {
            return;
        }
        $commandTester->setInputs([1]);
        $commandTester->execute([]);
        $display = $commandTester->getDisplay();
        $this->assertContains('Please select your favorite registry', $display);
        $this->assertContains('Use registry [phpcomposer] success', $display);
    }

    protected function createCommandTester()
    {
        $manager = new RegistryManagerStub();
        $manager->readRegistriesFromFile(ConfigPath::getDefaultConfigFile());
        $command = new UseCommand($manager);
        $command->setApplication(new Application());
        return new CommandTester($command);
    }
}
