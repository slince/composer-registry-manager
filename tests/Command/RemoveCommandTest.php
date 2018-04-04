<?php
namespace Slince\Crm\Tests\Command;

use Slince\Crm\Command\AddCommand;
use Slince\Crm\Command\ListCommand;
use Slince\Crm\Command\RemoveCommand;
use Slince\Crm\ConfigPath;
use Slince\Crm\ProxyApplication;
use Slince\Crm\RepositoryManager;
use Slince\Crm\Tests\Stub\RepositoryManagerStub;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Tester\CommandTester;

class RemoveCommandTest extends CommandTestCase
{
    public function testExecute()
    {
        $manager = new RepositoryManagerStub();
        $manager->readRegistriesFromFile(ConfigPath::getDefaultConfigFile());
        $this->runCommandTester(new AddCommand($manager), [
            'repository-name' => 'foo',
            'repository-url' => 'http://foo.com',
        ]);

        $this->assertRegExp('#foo\.com#', $this->runCommandTester(new ListCommand($manager), []));

        $this->runCommandTester(new RemoveCommand($manager), [
            'repository-name' => 'foo',
        ]);

        $this->assertNotRegExp('#foo\.com#', $this->runCommandTester(new ListCommand($manager), []));
    }

    public function testExecuteWithoutArgument()
    {
        $commandTester = $this->createCommandTester();

        //If the symfony/console version is less than 3.2, the test is not performed
        if (!method_exists($commandTester, 'setInputs')) {
            return;
        }
        $commandTester->setInputs([1]);
        $commandTester->execute([]);
        $display = $commandTester->getDisplay();
        $this->assertContains('Please select your favorite repository', $display);
        $this->assertContains('Remove registry [phpcomposer] success', $display);
    }


    protected function createCommandTester()
    {
        $manager = new RepositoryManagerStub();
        $manager->readRegistriesFromFile(ConfigPath::getDefaultConfigFile());
        $command = new RemoveCommand($manager);
        $command->setApplication(new ProxyApplication([]));
        return new CommandTester($command);
    }
}
