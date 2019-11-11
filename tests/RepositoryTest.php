<?php
namespace Slince\Crm\Tests;

use PHPUnit\Framework\TestCase;
use Slince\Crm\Repository;

class RepositoryTest extends TestCase
{

    public function testCreate()
    {
        $repository = new Repository('foo', 'http://bar.com');
        $this->assertEquals('foo', $repository->getName());
        $this->assertEquals('http://bar.com', $repository->getUrl());
    }

    public function testFactoryCreate()
    {
        $repository =  Repository::create([
            'name' => 'foo',
            'url' => 'http://bar.com'
        ]);
        $this->assertEquals('foo', $repository->getName());
        $this->assertEquals('http://bar.com', $repository->getUrl());

        $this->expectException(\InvalidArgumentException::class);
        Repository::create([
            'withoutName' => 'foo',
            'withoutUrl' => 'http://bar.com',
        ]);
    }

    public function testSet()
    {
        $repository =  Repository::create([
            'name' => 'foo',
            'url' => 'http://bar.com'
        ]);
        $this->assertEquals('foo', $repository->getName());
        $repository->setName('bar');
        $this->assertEquals('bar', $repository->getName());
        $repository->setUrl('http://foo.com');
        $this->assertEquals('http://foo.com', $repository->getUrl());
    }

    public function testReservedAttribute()
    {
        $repository =  Repository::create([
            'name' => 'foo',
            'url' => 'http://bar.com',
            'location' => 'China'
        ]);
        $this->assertEquals('China', $repository->getLocation());
        $this->assertEquals('http://bar.com', $repository->getUrl());

        $repository->setLocation('Russia');
        $this->assertEquals('Russia', $repository->getLocation());
    }

    public function testToArray()
    {
        $repository =  Repository::create([
            'name' => 'foo',
            'url' => 'http://bar.com'
        ]);
        $repositoryData = $repository->toArray();
        $this->assertArrayHasKey('name', $repositoryData);
        $this->assertArrayHasKey('url', $repositoryData);
        $this->assertArrayHasKey('location', $repositoryData);
    }
}
