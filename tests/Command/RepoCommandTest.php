<?php
namespace Slince\Crm\Tests\Command;

use Slince\Crm\Command\AddCommand;
use Slince\Crm\Command\ListCommand;
use Slince\Crm\Command\RepoCommand;
use Slince\Crm\Tests\Stub\RepositoryManagerStub;
use Symfony\Component\Console\Exception\RuntimeException;

class RepoCommandTest extends CommandTestCase
{
    protected static $logo = <<<EOT
 _____   _____        ___  ___  
/  ___| |  _  \      /   |/   | 
| |     | |_| |     / /|   /| | 
| |     |  _  /    / / |__/ | | 
| |___  | | \ \   / /       | | 
\_____| |_|  \_\ /_/        |_| 
EOT;

    public function testExecute()
    {
        $this->assertStringContainsString(static::$logo, $this->runCommandTest(RepoCommand::class, []));
    }
}
