<?php
namespace Slince\Crm\Tests\Command;

use Slince\Crm\Command\ListCommand;
use Slince\Crm\Command\UseCommand;
use Slince\Crm\RegistryManager;
use Slince\Crm\Registry;
use Slince\Crm\Exception\RuntimeException;
use Slince\Crm\Tests\Stub\RegistryManagerStub;
use Slince\Crm\Utils;

class ListCommandTest extends CommandTestCase
{
    public function testExecute()
    {
        $this->assertRegExp('#packagist\.org#', $this->runCommandTester(new ListCommand(new RegistryManagerStub()), []));
    }

    public function testForCurrent()
    {
        $manager = new RegistryManagerStub();
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
        $this->expectException(RuntimeException::class);
        $command = new UseCommand(new RegistryManagerStub());
        $command->setComposerFileName('for-test.json'); //Just for test
        $this->runCommandTester($command, [
            'registry-name' => 'phpcomposer',
            '--current' => true
        ]);
    }
}
