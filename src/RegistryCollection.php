<?php
/**
 * CRM library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Crm;

use Slince\Crm\Exception\InvalidArgumentException;

class RegistryCollection implements \IteratorAggregate,\ArrayAccess
{

    /**
     * @var Registry[]
     */
    protected $registries = [];

    /**
     * RegistryCollection constructor.
     * @param array $registries
     */
    public function __construct(array $registries = [])
    {
        $this->registries = $registries;
    }

    /**
     * Add a registry
     * @param Registry $registry
     */
    public function add(Registry $registry)
    {
        $this->registries[] = $registry;
    }

    /**
     * Add a registry
     * @param Registry $registry
     */
    public function remove(Registry $registry)
    {
        foreach ($this->registries as $index => $_registry) {
            if ($registry == $_registry) {
                unset($this->registries[$index]);
            }
        }
    }

    /**
     * Get all registries
     * @return Registry[]
     */
    public function all()
    {
        return $this->registries;
    }

    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        return array_map(function(Registry $registry){
            return $registry->toArray();
        }, $this->registries);
    }

    /**
     * @param $data
     * @throws InvalidArgumentException
     * @return static
     */
    public static function createFromArray($data)
    {
        return new static(array_map(function($registryData){
            return Registry::create($registryData);
        }, $data));
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->registries);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return isset($this->registries[$offset]);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return $this->registries[$offset];
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        unset($this->registries[$offset]);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        $this->registries[$offset] = $value;
    }
}