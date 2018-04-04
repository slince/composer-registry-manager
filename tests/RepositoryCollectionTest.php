<?php
namespace Slince\Crm\Tests;

use Slince\Crm\Repository;
use Slince\Crm\RepositoryCollection;
use PHPUnit\Framework\TestCase;

class RepositoryCollectionTest extends TestCase
{
    public function testCreate()
    {
        $registries = new RepositoryCollection([
            new Repository('foo', 'http://foo.com'),
            new Repository('bar', 'http://bar.com'),
        ]);
        $this->assertCount(2, $registries->all());
    }

    public function testCreateFromArray()
    {
        $registries = RepositoryCollection::fromArray([
            ['name' => 'foo', 'url' => 'http://foo.com'],
            ['name' => 'bar', 'url' => 'http://bar.com']
        ]);
        $this->assertCount(2, $registries->all());
    }

    public function testAdd()
    {
        $registries = RepositoryCollection::fromArray([
            ['name' => 'foo', 'url' => 'http://foo.com'],
            ['name' => 'bar', 'url' => 'http://bar.com']
        ]);
        $registries->add(new Repository('baz', 'http://baz.com'));
        $this->assertCount(3, $registries->all());
    }

    public function testRemove()
    {
        $registries = new RepositoryCollection([
            $foo = new Repository('foo', 'http://foo.com'),
            new Repository('bar', 'http://bar.com'),
        ]);
        $this->assertCount(2, $registries->all());
        $registries->remove($foo);
        $this->assertCount(1, $registries->all());
    }

    public function testToArray()
    {
        $registries = new RepositoryCollection([
            $foo = new Repository('foo', 'http://foo.com'),
            new Repository('bar', 'http://bar.com'),
        ]);
        $registriesData = $registries->toArray();
        $this->assertTrue(is_array($registriesData));
        $this->assertTrue(is_array($registriesData[0]));
        $this->assertEquals('bar', $registriesData[1]['name']);
        $this->assertEquals('http://bar.com', $registriesData[1]['url']);
    }

    public function testArrayAccess()
    {
        $registries = new RepositoryCollection([
            $foo = new Repository('foo', 'http://foo.com'),
            new Repository('bar', 'http://bar.com'),
        ]);
        $this->assertCount(2, $registries);
        $this->assertEquals('bar', $registries[1]->getName());
        $this->assertEquals('http://bar.com', $registries[1]->getUrl());
        unset($registries[0]);
        $this->assertCount(1, $registries);
    }
}
