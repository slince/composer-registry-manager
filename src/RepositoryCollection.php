<?php

/*
 * This file is part of the slince/composer-registry-manager package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slince\Crm;

class RepositoryCollection implements \IteratorAggregate, \ArrayAccess, \Countable
{
    /**
     * @var Repository[]
     */
    protected $repositories = [];

    /**
     * RegistryCollection constructor.
     *
     * @param array $repositories
     */
    public function __construct(array $repositories = [])
    {
        $this->repositories = $repositories;
    }

    /**
     * Search repository.
     *
     * @param string $name
     *
     * @return Repository|null
     */
    public function findByName($name)
    {
        $filtered = array_filter($this->repositories, function(Repository $repository) use ($name){
            return $repository->getName() === $name;
        });

        return $filtered ? reset($filtered) : null;
    }

    /**
     * Add a registry.
     *
     * @param Repository $repository
     */
    public function add(Repository $repository)
    {
        $this->repositories[] = $repository;
    }

    /**
     * Add a registry.
     *
     * @param Repository $repository
     */
    public function remove(Repository $repository)
    {
        foreach ($this->repositories as $index => $_registry) {
            if ($repository == $_registry) {
                unset($this->repositories[$index]);
            }
        }
    }

    /**
     * Get all registries.
     *
     * @return Repository[]
     */
    public function all()
    {
        return $this->repositories;
    }

    /**
     * Convert to array.
     *
     * @return array
     */
    public function toArray()
    {
        return array_map(function (Repository $repository) {
            return $repository->toArray();
        }, $this->repositories);
    }

    /**
     * @param array $data
     *
     * @return static
     */
    public static function fromArray($data)
    {
        return new static(array_map(function ($repositoryData) {
            return Repository::create($repositoryData);
        }, $data));
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->repositories);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return isset($this->repositories[$offset]);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return $this->repositories[$offset];
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        unset($this->repositories[$offset]);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        $this->repositories[$offset] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->repositories);
    }
}
