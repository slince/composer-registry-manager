<?php
namespace Slince\Crm\Tests;

use Slince\Crm\Utils;
use Symfony\Component\Filesystem\Filesystem;

class UtilsTest extends \PHPUnit_Framework_TestCase
{
    public function testGetFilesystem()
    {
        $this->assertInstanceOf(Filesystem::class, Utils::getFilesystem());
    }
}