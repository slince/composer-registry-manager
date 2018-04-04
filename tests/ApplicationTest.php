<?php
namespace Slince\Crm\Tests\Console;

use PHPUnit\Framework\TestCase;
use Slince\Crm\Application;
use Slince\Crm\ProxyApplication;

class ApplicationTest extends TestCase
{
    public function testConstructor()
    {
        $application = new ProxyApplication([]);
        $this->assertInstanceOf(\Symfony\Component\Console\Application::class, $application);
        $this->assertContains('Composer Repository Manager', $application->getName());
        $this->assertContains('Composer Repository Manager', $application->getHelp());
    }
}
