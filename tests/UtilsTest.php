<?php
namespace Slince\Crm\Tests;

use Slince\Crm\Utils;
use Symfony\Component\Filesystem\Filesystem;
use PHPUnit\Framework\TestCase;

class UtilsTest extends TestCase
{
    public function testGetFilesystem()
    {
        $this->assertInstanceOf(Filesystem::class, Utils::getFilesystem());
    }
}
