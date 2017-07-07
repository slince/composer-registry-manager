<?php
namespace Slince\Crm\Tests\Command;

use Slince\Crm\Command\AddCommand;
use Slince\Crm\Command\ListCommand;
use Slince\Crm\Command\RemoveCommand;
use Slince\Crm\RegistryManager;
use Slince\Crm\Tests\Stub\RegistryManagerStub;
use Symfony\Component\Console\Exception\RuntimeException;

class RemoveCommandTest extends CommandTestCase
{
    public function testExecute()
    {
        $manager = new RegistryManagerStub();

        $this->runCommandTester(new AddCommand($manager), [
            'registry-name' => 'foo',
            'registry-url' => 'http://foo.com',
        ]);

        $this->assertRegExp('#foo\.com#', $this->runCommandTester(new ListCommand($manager), []));

        $this->runCommandTester(new RemoveCommand($manager), [
            'registry-name' => 'foo',
        ]);

        $this->assertNotRegExp('#foo\.com#', $this->runCommandTester(new ListCommand($manager), []));
    }

    public function testExecuteWithoutArgument()
    {
        $this->expectException(RuntimeException::class);
        $this->runCommandTester(new RemoveCommand(new RegistryManagerStub()), []);
    }
}
