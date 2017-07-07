<?php
namespace Slince\Crm\Tests;

use PHPUnit\Framework\TestCase;
use Slince\Crm\ConfigPath;

class ConfigPathTest extends TestCase
{
    public function testHomeConfigDir()
    {
        $this->assertTrue((boolean)preg_match('/win/i', PHP_OS) === ConfigPath::isWindows());
    }

    public function testDefaultConfigFile()
    {
        $this->assertFileExists(ConfigPath::getDefaultConfigFile());
    }
}