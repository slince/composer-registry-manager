<?php
namespace Slince\Crm\Tests;

use PHPUnit\Framework\TestCase;
use Slince\Crm\Exception\InvalidArgumentException;
use Slince\Crm\Registry;

class RegistryTest extends TestCase
{

    public function testCreate()
    {
        $registry = new Registry('foo', 'http://bar.com');
        $this->assertEquals('foo', $registry->getName());
        $this->assertEquals('http://bar.com', $registry->getUrl());
    }

    public function testFactoryCreate()
    {
        $registry =  Registry::create([
            'name' => 'foo',
            'url' => 'http://bar.com'
        ]);
        $this->assertEquals('foo', $registry->getName());
        $this->assertEquals('http://bar.com', $registry->getUrl());

        $this->expectException(InvalidArgumentException::class);
        Registry::create([
            'withoutName' => 'foo',
            'withoutUrl' => 'http://bar.com',
        ]);
    }

    public function testSet()
    {
        $registry =  Registry::create([
            'name' => 'foo',
            'url' => 'http://bar.com'
        ]);
        $this->assertEquals('foo', $registry->getName());
        $registry->setName('bar');
        $this->assertEquals('bar', $registry->getName());
        $registry->setUrl('http://foo.com');
        $this->assertEquals('http://foo.com', $registry->getUrl());
    }

    public function testReservedAttribute()
    {
        $registry =  Registry::create([
            'name' => 'foo',
            'url' => 'http://bar.com',
            'homepage' => 'http://baz.com',
            'author' => 'Steven'
        ]);
        $this->assertEquals('http://baz.com', $registry->getHomepage());
        $this->assertEquals('Steven', $registry->getAuthor());

        $registry->setHomepage('http://bar.com');
        $registry->setAuthor('Bob');

        $this->assertEquals('http://bar.com', $registry->getHomepage());
        $this->assertEquals('Bob', $registry->getAuthor());
    }

    public function testToArray()
    {
        $registry =  Registry::create([
            'name' => 'foo',
            'url' => 'http://bar.com'
        ]);
        $registryData = $registry->toArray();
        $this->assertArrayHasKey('name', $registryData);
        $this->assertArrayHasKey('url', $registryData);
        $this->assertArrayHasKey('homepage', $registryData);
        $this->assertArrayHasKey('author', $registryData);
    }
}
