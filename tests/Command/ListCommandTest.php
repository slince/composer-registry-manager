<?php
namespace Slince\Crm\Tests\Command;

use Slince\Crm\Command\ListCommand;
use Slince\Crm\Tests\Stub\RepositoryManagerStub;
use Slince\Crm\Utils;

class ListCommandTest extends CommandTestCase
{
    public function testExecute()
    {
        $manager = new RepositoryManagerStub();
        $manager->readRegistriesFromFile(Utils::getDefaultConfigFile());
        $this->assertStringContainsString('packagist.org', $this->runCommandTester(new ListCommand($manager), []));
    }
}
