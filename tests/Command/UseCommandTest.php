<?php
namespace Slince\Crm\Tests\Command;

use Slince\Crm\Command\AddCommand;
use Slince\Crm\Command\UseCommand;
use Slince\Crm\Manager;
use Symfony\Component\Console\Exception\RuntimeException;

class UseCommandTest extends CommandTestCase
{
    public function testExecute()
    {
        $manager = new Manager();
        $this->runCommandTester(new AddCommand($manager), [
            'registry-name' => 'foo',
            'registry-url' => 'http://foo.com',
        ]);
        $this->assertNotEquals('http://foo.com', $manager->getCurrentRegistry()->getUrl());
        $this->runCommandTester(new UseCommand($manager), [
            'registry-name' => 'foo',
        ]);
        $this->assertEquals('http://foo.com', $manager->getCurrentRegistry()->getUrl());
    }

    public function testExecuteWithoutArgument()
    {
        $manager = new Manager();
        $this->setExpectedException(RuntimeException::class);
        $this->runCommandTester(new UseCommand($manager), []);
    }
}
