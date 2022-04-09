<?php
namespace Slince\Crm\Tests\Command;

use Slince\Crm\ProxyApplication;
use Slince\Crm\Command\AddCommand;
use Slince\Crm\Command\UseCommand;
use Slince\Crm\Tests\Stub\RepositoryManagerStub;
use Slince\Crm\Utils;
use Symfony\Component\Console\Tester\CommandTester;

class UseCommandTest extends CommandTestCase
{
    public function testExecute()
    {
        $manager = new RepositoryManagerStub();
        $addCommand = $this->getMockBuilder(AddCommand::class)->onlyMethods(['getApplication'])
            ->setConstructorArgs([$manager])
            ->getMock();
        $this->runCommandTester($addCommand, [
            'repository-name' => 'foo',
            'repository-url' => 'http://foo.com',
        ]);
        $useCommand = $this->getMockBuilder(UseCommand::class)->onlyMethods(['getApplication'])
            ->setConstructorArgs([$manager])
            ->getMock();
        $this->runCommandTester($useCommand, [
            'repository-name' => 'foo',
        ]);
        $this->assertEquals('http://foo.com', $manager->getCurrentRepository()->getUrl());
    }

    public function testExecuteForCurrent()
    {
        $manager = new RepositoryManagerStub();
        $manager->readRegistriesFromFile(Utils::getDefaultConfigFile());

        $addCommand = $this->getMockBuilder(AddCommand::class)->onlyMethods(['getApplication'])
            ->setConstructorArgs([$manager])
            ->getMock();

        $this->runCommandTester($addCommand, [
            'repository-name' => 'bar',
            'repository-url' => 'http://bar.com',
        ]);

        $useCommand = $this->getMockBuilder(UseCommand::class)->onlyMethods(['getApplication'])
            ->setConstructorArgs([$manager])
            ->getMock();
        $this->runCommandTester($useCommand, [
            'repository-name' => 'composer',
        ]);
        $this->runCommandTester($useCommand, [
            'repository-name' => 'bar',
            '--current' => true
        ]);
        $this->assertEquals('https://packagist.org', $manager->getCurrentRepository()->getUrl());
        $this->assertEquals('http://bar.com', $manager->getCurrentRepository(true)->getUrl());
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
        $this->assertStringContainsString('Please select your favorite repository', $display);
        $this->assertStringContainsString('Use the repository [composer] success', $display);
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
        $this->assertStringContainsString('Please select your favorite repository', $display);
        $this->assertStringContainsString('Use the repository [aliyun] success', $display);
    }

    protected function createCommandTester()
    {
        $manager = new RepositoryManagerStub();
        $manager->readRegistriesFromFile(Utils::getDefaultConfigFile());
        $command = $this->getMockBuilder(UseCommand::class)->onlyMethods(['getApplication'])
            ->setConstructorArgs([$manager])
            ->getMock();
        $command->setApplication(new ProxyApplication([]));
        return new CommandTester($command);
    }
}
