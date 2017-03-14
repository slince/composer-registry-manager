<?php
namespace Slince\Crm\Tests\Command;

use Slince\Crm\Command\ResetCommand;
use Slince\Crm\Manager;

class ResetCommandTest extends CommandTestCase
{
    public function testExecute()
    {
        $manager = new Manager();
        $this->assertRegExp('#Confirm#', $this->runCommandTester(new ResetCommand($manager), [
        ]));
    }
}