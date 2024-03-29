<?php
namespace Slince\Crm\Tests\Command;

use Slince\Crm\Command\ResetCommand;
use Slince\Crm\Command\UseCommand;
use Slince\Crm\ProxyApplication;
use Slince\Crm\Tests\Stub\RepositoryManagerStub;
use Slince\Crm\Utils;
use Symfony\Component\Console\Tester\CommandTester;

class ResetCommandTest extends CommandTestCase
{
    public function testExecute()
    {
        $manager = new RepositoryManagerStub();
        $manager->readRegistriesFromFile(Utils::getDefaultConfigFile());
        $command = $this->getMockBuilder(ResetCommand::class)->onlyMethods(['getApplication'])
            ->setConstructorArgs([$manager])
            ->getMock();
        $command->setApplication(new ProxyApplication([]));
        $commandTester = new CommandTester($command);
        //If the symfony/console version is less than 3.2, the test is not performed
        if (!method_exists($commandTester, 'setInputs')) {
            return;
        }
        $commandTester->setInputs(['y']);
        $commandTester->execute([]);
        $display = $commandTester->getDisplay();
        $this->assertStringContainsString('This command will remove custom repositories. Are you sure to do this', $display);
        $this->assertStringContainsString('Successfully reset', $display);
    }
}
