<?php
namespace Slince\Crm\Tests\Command;

use Slince\Crm\Command\ListCommand;
use Slince\Crm\Manager;

class ListCommandTest extends CommandTestCase
{
    public function testExecute()
    {
        $this->assertRegExp('#packagist\.org#', $this->runCommandTester(new ListCommand(new Manager()), []));
    }
}