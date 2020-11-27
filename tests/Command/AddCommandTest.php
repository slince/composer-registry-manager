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
        $manager = new RepositoryManagerStub();
        $method = method_exists($this, 'assertMatchesRegularExpression')
            ? 'assertMatchesRegularExpression' : 'assertRegExp';
        $this->$method('#success#', $this->runCommandTester(new AddCommand($manager), [
            'repository-name' => 'foo',
            'repository-url' => 'http://foo.com',
        ]));
        $this->assertStringContainsString('http://foo.com', $this->runCommandTester(new ListCommand($manager), []));
    }

    public function testExecuteWithoutArgument()
    {
        $manager = new RepositoryManagerStub();
        $this->expectException(RuntimeException::class);
        $this->runCommandTester(new AddCommand($manager), [
            'repository-name' => 'foo',
        ]);
    }
}
