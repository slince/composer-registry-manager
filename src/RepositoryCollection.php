<?php

declare(strict_types=1);

/*
 * This file is part of the slince/composer-registry-manager package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slince\Crm;

final class RepositoryCollection implements \IteratorAggregate, \Countable
{
    /**
     * @var Repository[]
     */
    protected array $repositories = [];

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
    public function search(string $name): ?Repository
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
    public function has(Repository $repository): bool
    {
        return in_array($repository, $this->repositories);
    }

    /**
     * Get all registries.
     *
     * @return Repository[]
     */
    public function all(): array
    {
        return $this->repositories;
    }

    /**
     * Convert to array.
     *
     * @return array
     */
    public function toArray(): array
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
    public static function fromArray(array $data): RepositoryCollection
    {
        return new RepositoryCollection(array_map(fn($repositoryData) => Repository::create($repositoryData), $data));
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->repositories);
    }

    /**
     * {@inheritdoc}
     */
    public function count(): int
    {
        return count($this->repositories);
    }
}
