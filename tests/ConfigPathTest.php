<?php
namespace Slince\Crm\Tests;

use PHPUnit\Framework\TestCase;
use Slince\Crm\ConfigPath;

class ConfigPathTest extends TestCase
{
    public function testHomeConfigDir()
    {
        $this->assertTrue((boolean)(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') === ConfigPath::isWindows());
    }

    public function testDefaultConfigFile()
    {
        $this->assertFileExists(ConfigPath::getDefaultConfigFile());
    }
}
