<?php
namespace Slince\Crm\Tests\Command;

use Slince\Crm\Command\AddCommand;
use Slince\Crm\Command\ListCommand;
use Slince\Crm\Tests\Stub\RegistryManagerStub;
use Symfony\Component\Console\Exception\RuntimeException;

class AddCommandTest extends CommandTestCase
{
    public function testExecute()
    {
        $manager = new RegistryManagerStub();
        $this->assertRegExp('#success#', $this->runCommandTester(new AddCommand($manager), [
            'registry-name' => 'foo',
            'registry-url' => 'http://foo.com',
        ]));
        $this->assertRegExp('#foo.com#', $this->runCommandTester(new ListCommand($manager), []));
    }

    public function testExecuteWithoutArgument()
    {
        $manager = new RegistryManagerStub();
        $this->expectException(RuntimeException::class);
        $this->runCommandTester(new AddCommand($manager), [
            'registry-name' => 'foo',
        ]);
    }
}
