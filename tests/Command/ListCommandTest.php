<?php
namespace Slince\Crm\Tests\Command;

use Slince\Crm\Command\ListCommand;
use Slince\Crm\Tests\Stub\RepositoryManagerStub;
use Slince\Crm\Utils;

class ListCommandTest extends CommandTestCase
{
    public function testExecute()
    {
        $this->assertStringContainsString('packagist.org', $this->runCommandTest(ListCommand::class, []));
    }
}
