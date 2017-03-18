<?php
namespace Slince\Crm\Tests\Command;

use Slince\Crm\Command\ListCommand;
use Slince\Crm\Command\UseCommand;
use Slince\Crm\Manager;
use Slince\Crm\Registry;
use Slince\Crm\Exception\RuntimeException;
use Slince\Crm\Utils;

class ListCommandTest extends CommandTestCase
{
    public function testExecute()
    {
        $this->assertRegExp('#packagist\.org#', $this->runCommandTester(new ListCommand(new Manager()), []));
    }

    public function testForCurrent()
    {
        $manager = new Manager();
        $this->runCommandTester(new UseCommand($manager), [
            'registry-name' => 'phpcomposer',
            '--current' => true
        ]);
        $this->assertContains('* phpcomposer', $this->runCommandTester(new ListCommand($manager), [
            '--current' => true
        ]));
    }

    public function testForCurrentException()
    {
        $this->setExpectedException(RuntimeException::class);
        $command = new UseCommand(new Manager());
        $command->setComposerFileName('for-test.json'); //Just for test
        $this->runCommandTester($command, [
            'registry-name' => 'phpcomposer',
            '--current' => true
        ]);
    }
}
