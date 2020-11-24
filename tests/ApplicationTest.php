<?php
namespace Slince\Crm\Tests;

use PHPUnit\Framework\TestCase;
use Slince\Crm\ProxyApplication;

class ApplicationTest extends TestCase
{
    public function testConstructor()
    {
        $application = new ProxyApplication([]);
        $this->assertInstanceOf(\Symfony\Component\Console\Application::class, $application);
        $this->assertStringContainsString('Composer Repository Manager', $application->getName());
        $this->assertStringContainsString('Composer Repository Manager', $application->getHelp());
    }
}
