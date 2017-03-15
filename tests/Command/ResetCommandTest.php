<?php
namespace Slince\Crm\Tests\Command;

use Slince\Crm\Command\ResetCommand;
use Slince\Crm\Console\Application;
use Slince\Crm\Manager;
use Symfony\Component\Console\Tester\CommandTester;

class ResetCommandTest extends CommandTestCase
{
    public function testExecute()
    {
        $commandTester = $this->createCommandTester();
        $commandTester->execute([]);
        $display = $commandTester->getDisplay();
        $this->assertContains('Confirm to reset repository configurations', $display);
    }

    protected function createCommandTester()
    {
        $command = new ResetCommand(new Manager());
        $command->setApplication(new Application());
        return new CommandTester($command);
    }
}
