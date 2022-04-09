<?php
namespace Slince\Crm\Tests\Command;

use Slince\Crm\Command\AddCommand;
use Slince\Crm\Command\ListCommand;
use Slince\Crm\Tests\Stub\RepositoryManagerStub;
use Symfony\Component\Console\Exception\RuntimeException;

class AddCommandTest extends CommandTestCase
{
    public function testExecute()
    {
        $this->assertMatchesRegularExpression('#success#', $this->runCommandTest(AddCommand::class, [
            'repository-name' => 'foo',
            'repository-url' => 'http://foo.com',
        ]));
        $this->assertStringContainsString('http://foo.com', $this->runCommandTest(ListCommand::class, []));
    }

    public function testExecuteWithoutArgument()
    {
        $this->expectException(RuntimeException::class);
        $this->runCommandTest(AddCommand::class, [
            'repository-name' => 'foo',
        ]);
    }
}
