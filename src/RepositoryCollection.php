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

class RepositoryCollection implements \IteratorAggregate, \Countable
{
    /**
     * @var Repository[]
     */
    protected $repositories = [];

    /**
     * @param array $repositories
     */
    public function __construct(array $repositories = [])
    {
        $this->repositories = $repositories;
    }

    /**
     * Search a repository by the name.
     *
     * @param string $name
     *
     * @return Repository|null
     */
    public function search($name)
    {
        $filtered = array_filter($this->repositories, function(Repository $repository) use ($name){
            return $repository->getName() === $name;
        });

        return $filtered ? reset($filtered) : null;
    }

    /**
     * Add a repository.
     *
     * @param Repository $repository
     */
    public function add(Repository $repository)
    {
        $this->repositories[] = $repository;
    }

    /**
     * Remove a repository.
     *
     * @param Repository $repository
     */
    public function remove(Repository $repository)
    {
        $key = array_search($repository, $this->repositories);
        if ($key !== false) {
            unset($this->repositories[$key]);
        }
    }

    /**
     *
     * Checks whether the repository exists.
     *
     * @param Repository $repository
     *
     * @return boolean
     */
    public function has(Repository $repository)
    {
        return array_search($repository, $this->repositories) !== false;
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
     * Creates a collection from array data.
     *
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
    public function count()
    {
        return count($this->repositories);
    }
}
