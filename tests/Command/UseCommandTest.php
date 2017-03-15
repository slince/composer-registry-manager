<?php
namespace Slince\Crm\Tests\Command;

use Slince\Crm\Command\AddCommand;
use Slince\Crm\Command\UseCommand;
use Slince\Crm\Console\Application;
use Slince\Crm\Manager;
use Symfony\Component\Console\Tester\CommandTester;

class UseCommandTest extends CommandTestCase
{
    public function testExecute()
    {
        $manager = new Manager();
        $this->runCommandTester(new AddCommand($manager), [
            'registry-name' => 'foo',
            'registry-url' => 'http://foo.com',
        ]);
        $this->assertNotEquals('http://foo.com', $manager->getCurrentRegistry()->getUrl());
        $this->runCommandTester(new UseCommand($manager), [
            'registry-name' => 'foo',
        ]);
        $this->assertEquals('http://foo.com', $manager->getCurrentRegistry()->getUrl());
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
        $command = new UseCommand(new Manager());
        $command->setApplication(new Application());
        return new CommandTester($command);
    }
}
