<?php
namespace Slince\Crm\Tests\Command;

use Slince\Crm\Command\ListCommand;
use Slince\Crm\Manager;

class ListCommandTest extends CommandTestCase
{
    public function testExecute()
    {
        $display = $this->runCommandTester(new ListCommand(new Manager()));
        var_dump($display);
        exit;
    }
}