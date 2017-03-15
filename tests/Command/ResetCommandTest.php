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

        //If the symfony/console version is less than 3.2, the test is not performed
        if (!method_exists($commandTester, 'setInputs')) {
            return;
        }
        
        $commandTester->setInputs([PHP_EOL]);
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
