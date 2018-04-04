<?php
namespace Slince\Crm\Tests\Command;

use Slince\Crm\Command\ListCommand;
use Slince\Crm\Command\UseCommand;
use Slince\Crm\ConfigPath;
use Slince\Crm\RepositoryManager;
use Slince\Crm\Repository;
use Slince\Crm\Exception\RuntimeException;
use Slince\Crm\Tests\Stub\RepositoryManagerStub;
use Slince\Crm\Utils;

class ListCommandTest extends CommandTestCase
{
    public function testExecute()
    {
        $manager = new RepositoryManagerStub();
        $manager->readRegistriesFromFile(ConfigPath::getDefaultConfigFile());
        $this->assertContains('packagist.org', $this->runCommandTester(new ListCommand($manager), []));
    }
}
