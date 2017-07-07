<?php
namespace Slince\Crm\Tests\Console;

use Slince\Crm\Application;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $application = new Application();
        $this->assertInstanceOf(\Symfony\Component\Console\Application::class, $application);
        $this->assertEquals(Application::NAME, $application->getName());
    }
}
