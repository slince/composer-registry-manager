<?php
namespace Slince\Crm\Tests\Command;

use Slince\Crm\Command\Command;
use Slince\Crm\Tests\Stub\RegistryManagerStub;

class CommandTest extends \PHPUnit_Framework_TestCase
{
    protected function createCommand()
    {
        $manager = new RegistryManagerStub();
        return new Command($manager, 'foo');
    }

    public function testGetManager()
    {
        $command = $this->createCommand();
        $this->assertInstanceOf(RegistryManagerStub::class, $command->getManager());
    }
}
