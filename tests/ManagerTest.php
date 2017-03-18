<?php
namespace Slince\Crm\Tests;

use Slince\Crm\Exception\InvalidArgumentException;
use Slince\Crm\Exception\RegistryNotExistsException;
use Slince\Crm\Manager;
use Slince\Crm\Registry;
use Slince\Crm\RegistryCollection;
use Slince\Crm\Utils;

class ManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testGetRegistries()
    {
        $this->assertInstanceOf(RegistryCollection::class, (new Manager())->getRegistries());
    }

    public function testAddRegistry()
    {
        $manager = new Manager();
        $this->assertCount(0, $manager->getRegistries()->all());
        $manager->addRegistry('foo', 'http://foo.com');
        $this->assertCount(1, $manager->getRegistries()->all());
        $this->assertEquals('foo', $manager->getRegistries()->all()[0]->getName());
        $this->assertEquals('http://foo.com', $manager->getRegistries()->all()[0]->getUrl());
    }

    public function testFindRegistry()
    {
        $manager = new Manager();
        $registry = $manager->addRegistry('foo', 'http://foo.com');
        $this->assertTrue($registry === $manager->findRegistry('foo'));

        $this->setExpectedException(RegistryNotExistsException::class);
        $manager->findRegistry('not_exists_registry');
    }

    public function testRemoveRegistry()
    {
        $manager = new Manager();
        $registry = $manager->addRegistry('foo', 'http://foo.com');
        $manager->removeRegistry('foo');
        $this->setExpectedException(RegistryNotExistsException::class);
        $manager->findRegistry('foo');
    }

    public function testGetCurrentRegistry()
    {
        $manager = new Manager();
        $registry = $manager->getCurrentRegistry();
        $this->assertRegExp('#packagist\.org#', $registry->getUrl());
    }

    public function testUseRegistry()
    {
        $manager = new Manager();
        $registry = new Registry('foo', 'http://foo.com');
        $manager->useRegistry($registry);
        $this->assertRegExp('#foo\.com#', $manager->getCurrentRegistry()->getUrl());
        //Reset composer
        $registry = new Registry('composer', 'https://packagist.org');
        $manager->useRegistry($registry);
    }

    public function testUseRegistryForCurrent()
    {
        $manager = new Manager();
        $fooRegistry = new Registry('foo', 'http://foo.com');
        $barRegistry = new Registry('bar', 'http://bar.com');
        $manager->useRegistry($fooRegistry, true);
        $manager->useRegistry($barRegistry);
        $this->assertNotRegExp('#foo\.com#', $manager->getCurrentRegistry()->getUrl());
        $this->assertRegExp('#foo\.com#', $manager->getCurrentRegistry(true)->getUrl());
        $this->assertRegExp('#bar\.com#', $manager->getCurrentRegistry()->getUrl());
        //Reset composer
        $registry = new Registry('composer', 'https://packagist.org');
        $manager->useRegistry($registry);
    }

    public function testReadRegistriesFromFile()
    {
        $configFile = __DIR__ . '/../crm.default.json';
        $manager = new Manager();
        $manager->readRegistriesFromFile($configFile);
        $this->assertNotEmpty($manager->getRegistries()->all());
        $this->setExpectedException(InvalidArgumentException::class);
        $manager->readRegistriesFromFile('file/not/exiss.json');
    }

    public function testDumpRepositoriesToFile()
    {
        $configFile = __DIR__ . '/../crm.default.json';
        $targetConfigFile = __DIR__ .  '/tmp/crm.json';
        $manager = new Manager();
        $manager->readRegistriesFromFile($configFile);
        $manager->dumpRepositoriesToFile($targetConfigFile);
        $this->assertFileExists($targetConfigFile);
        $this->assertEquals(Utils::readJsonFile($configFile)[0]['name'], Utils::readJsonFile($targetConfigFile)[0]['name']);
        $this->assertEquals(Utils::readJsonFile($configFile)[0]['url'], Utils::readJsonFile($targetConfigFile)[0]['url']);
        //Remove tmp dir
        Utils::getFilesystem()->remove(__DIR__ . '/tmp');
    }
}
