<?php
namespace Slince\Crm\Tests;

use PHPUnit\Framework\TestCase;
use Slince\Crm\ConfigPath;
use Slince\Crm\Exception\InvalidArgumentException;
use Slince\Crm\Exception\RegistryNotExistsException;
use Slince\Crm\Repository;
use Slince\Crm\RepositoryCollection;
use Slince\Crm\Utils;
use Slince\Crm\Tests\Stub\RegistryManagerStub;

class RegistryManagerTest extends TestCase
{
    public function testGetRegistries()
    {
        $this->assertInstanceOf(RepositoryCollection::class, (new RegistryManagerStub())->getRegistries());
    }

    public function testAddRegistry()
    {
        $manager = new RegistryManagerStub();
        $this->assertCount(0, $manager->getRegistries()->all());
        $manager->addRegistry('foo', 'http://foo.com');
        $this->assertCount(1, $manager->getRegistries()->all());
        $this->assertEquals('foo', $manager->getRegistries()->all()[0]->getName());
        $this->assertEquals('http://foo.com', $manager->getRegistries()->all()[0]->getUrl());
        $this->expectException(InvalidArgumentException::class);
        $manager->addRegistry('foo', 'http://foo.com');
    }

    public function testFindRegistry()
    {
        $manager = new RegistryManagerStub();
        $registry = $manager->addRegistry('foo', 'http://foo.com');
        $this->assertTrue($registry === $manager->findRegistry('foo'));

        $this->expectException(RegistryNotExistsException::class);
        $manager->findRegistry('not_exists_registry');
    }

    public function testRemoveRegistry()
    {
        $manager = new RegistryManagerStub();
        $registry = $manager->addRegistry('foo', 'http://foo.com');
        $manager->removeRegistry('foo');
        $this->expectException(RegistryNotExistsException::class);
        $manager->findRegistry('foo');
    }

    public function testUseRegistry()
    {
        $manager = new RegistryManagerStub();
        $registry = new Repository('foo', 'http://foo.com');
        $manager->useRegistry($registry);
        $this->assertRegExp('#foo\.com#', $manager->getCurrentRegistry()->getUrl());
    }


    public function testReadRegistriesFromFile()
    {
        $configFile = ConfigPath::getDefaultConfigFile();
        $manager = new RegistryManagerStub();
        $manager->readRegistriesFromFile($configFile);
        $this->assertNotEmpty($manager->getRegistries()->all());
        $this->expectException(InvalidArgumentException::class);
        $manager->readRegistriesFromFile('file/not/exiss.json');
    }

    public function testDumpRepositoriesToFile()
    {
        $configFile = ConfigPath::getDefaultConfigFile();
        $targetConfigFile = tempnam(sys_get_temp_dir(),  'crm');
        $manager = new RegistryManagerStub();
        $manager->readRegistriesFromFile($configFile);
        $manager->dumpRepositoriesToFile($targetConfigFile);
        $this->assertFileExists($targetConfigFile);
        $this->assertEquals(Utils::readJsonFile($configFile)[0]['name'], Utils::readJsonFile($targetConfigFile)[0]['name']);
        $this->assertEquals(Utils::readJsonFile($configFile)[0]['url'], Utils::readJsonFile($targetConfigFile)[0]['url']);
        //Remove tmp dir
    }
}
