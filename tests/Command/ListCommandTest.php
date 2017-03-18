<?php
namespace Slince\Crm\Tests\Command;

use Slince\Crm\Command\ListCommand;
use Slince\Crm\Command\UseCommand;
use Slince\Crm\Manager;
use Slince\Crm\Registry;

class ListCommandTest extends CommandTestCase
{
    public function testExecute()
    {
        $this->assertRegExp('#packagist\.org#', $this->runCommandTester(new ListCommand(new Manager()), []));
    }

    public function testWithCurrent()
    {
        $manager = new Manager();
        $this->runCommandTester(new UseCommand($manager), [
            'registry-name' => 'phpcomposer'
        ], [
            '-c'
        ]);
        $this->assertContains('* phpcomposer', $this->runCommandTester(new ListCommand($manager), [], ['-c']));
    }
}
