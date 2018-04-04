<?php
namespace Slince\Crm\Tests;

use PHPUnit\Framework\TestCase;
use \InvalidArgumentException;
use Slince\Crm\Repository;
use Slince\Crm\RepositoryCollection;
use Slince\Crm\Tests\Stub\RepositoryManagerStub;

class RepositoryManagerTest extends TestCase
{
    public function testGetRepositories()
    {
        $this->assertInstanceOf(RepositoryCollection::class, (new RepositoryManagerStub())->getRepositories());
    }

    public function testAddRepository()
    {
        $manager = new RepositoryManagerStub();
        $this->assertCount(0, $manager->getRepositories()->all());
        $manager->addRepository('foo', 'http://foo.com');
        $this->assertCount(1, $manager->getRepositories()->all());
        $this->assertEquals('foo', $manager->getRepositories()->all()[0]->getName());
        $this->assertEquals('http://foo.com', $manager->getRepositories()->all()[0]->getUrl());
        $manager->addRepository('foo', 'http://foo.com');
    }

    public function testFindRepository()
    {
        $manager = new RepositoryManagerStub();
        $repository = $manager->addRepository('foo', 'http://foo.com');
        $this->assertTrue($repository === $manager->getRepositories()->findByName('foo'));
    }

    public function testRemoveRepository()
    {
        $manager = new RepositoryManagerStub();
        $repository = $manager->addRepository('foo', 'http://foo.com');
        $manager->removeRepository('foo');
        $this->assertNull($manager->getRepositories()->findByName('foo'));
    }

    public function testUseRepository()
    {
        $manager = new RepositoryManagerStub();
        $repository = new Repository('foo', 'http://foo.com');
        $manager->useRepository($repository);
        $this->assertRegExp('#foo\.com#', $manager->getCurrentRepository()->getUrl());
    }
}
