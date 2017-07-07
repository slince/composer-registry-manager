<?php
namespace Slince\Crm\Tests;

use Slince\Crm\Registry;
use Slince\Crm\RegistryCollection;
use PHPUnit\Framework\TestCase;

class RegistryCollectionTest extends TestCase
{
    public function testCreate()
    {
        $registries = new RegistryCollection([
            new Registry('foo', 'http://foo.com'),
            new Registry('bar', 'http://bar.com'),
        ]);
        $this->assertCount(2, $registries->all());
    }

    public function testCreateFromArray()
    {
        $registries = RegistryCollection::fromArray([
            ['name' => 'foo', 'url' => 'http://foo.com'],
            ['name' => 'bar', 'url' => 'http://bar.com']
        ]);
        $this->assertCount(2, $registries->all());
    }

    public function testAdd()
    {
        $registries = RegistryCollection::fromArray([
            ['name' => 'foo', 'url' => 'http://foo.com'],
            ['name' => 'bar', 'url' => 'http://bar.com']
        ]);
        $registries->add(new Registry('baz', 'http://baz.com'));
        $this->assertCount(3, $registries->all());
    }

    public function testRemove()
    {
        $registries = new RegistryCollection([
            $foo = new Registry('foo', 'http://foo.com'),
            new Registry('bar', 'http://bar.com'),
        ]);
        $this->assertCount(2, $registries->all());
        $registries->remove($foo);
        $this->assertCount(1, $registries->all());
    }

    public function testToArray()
    {
        $registries = new RegistryCollection([
            $foo = new Registry('foo', 'http://foo.com'),
            new Registry('bar', 'http://bar.com'),
        ]);
        $registriesData = $registries->toArray();
        $this->assertTrue(is_array($registriesData));
        $this->assertTrue(is_array($registriesData[0]));
        $this->assertEquals('bar', $registriesData[1]['name']);
        $this->assertEquals('http://bar.com', $registriesData[1]['url']);
    }
}
