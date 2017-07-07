<?php
namespace Slince\Crm\Tests\Console;

use PHPUnit\Framework\TestCase;
use Slince\Crm\Application;

class ApplicationTest extends TestCase
{
    public function testConstructor()
    {
        $application = new Application();
        $this->assertInstanceOf(\Symfony\Component\Console\Application::class, $application);
        $this->assertContains('Composer Registry Manager', $application->getName());
    }
}
