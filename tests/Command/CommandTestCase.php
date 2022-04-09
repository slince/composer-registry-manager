<?php
namespace Slince\Crm\Tests\Command;

use Composer\Console\Application;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Slince\Crm\Command\Command;
use Slince\Crm\Tests\Stub\RepositoryManagerStub;
use Slince\Crm\Utils;
use Symfony\Component\Console\Tester\CommandTester;

class CommandTestCase extends TestCase
{
    protected function runCommandTester(MockObject|Command $command, $arguments, $options = [])
    {
        $this->resolveCommand($command);
        $commandTester = new CommandTester($command);
        $commandTester->execute($arguments, $options);
        return $commandTester->getDisplay();
    }

    protected function runCommandTest(string $commandClass, $arguments, $options = []): string
    {
        $command = $this->createMockCommand($commandClass);
        $commandTester = new CommandTester($command);
        $commandTester->execute($arguments, $options);
        return $commandTester->getDisplay();
    }

    protected function createMockCommand(string $commandClass, bool $defaultRepos = false): Command
    {
        $manager = new RepositoryManagerStub();
        $defaultRepos && $manager->readRegistriesFromFile(Utils::getDefaultConfigFile());

        $command = $this->getMockBuilder($commandClass)
            ->onlyMethods(['getApplication'])
            ->setConstructorArgs([$manager])
            ->getMock();
        $this->resolveCommand($command);

        return $command;
    }

    protected function resolveCommand(MockObject $command): MockObject
    {
        $application = new Application();
        $command->method('getApplication')->willReturn($application);
        return $command;
    }
}
