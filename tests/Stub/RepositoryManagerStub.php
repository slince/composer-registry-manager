<?php

namespace Slince\Crm\Tests\Stub;

use Slince\Crm\Repository;
use Slince\Crm\RepositoryCollection;
use Slince\Crm\RepositoryManager;
use Slince\Crm\Utils;

class RepositoryManagerStub extends RepositoryManager
{
    protected $currentRepository;

    protected $repository;


    public function __construct()
    {
        static::$repositories = new RepositoryCollection();
    }

    public function useRepository(Repository $repository, bool $modifyCurrent = false)
    {
        if ($modifyCurrent) {
            $this->currentRepository = $repository;
        } else {
            $this->repository = $repository;
        }
    }

    public function addRepository(string $name, string $url, string $location = null): Repository
    {
        $repository = Repository::create([
            'name' => $name,
            'url' => $url,
            'location' => $location
        ]);
        static::$repositories->add($repository);
        return $repository;
    }

    public function getRepositories(): RepositoryCollection
    {
        return static::$repositories;
    }

    public function getCurrentRepository($isCurrent = false)
    {
        return $isCurrent ? $this->currentRepository : $this->repository;
    }

    public function readRegistriesFromFile($file)
    {
        static::$repositories = RepositoryCollection::fromArray(Utils::readJsonFile($file));
    }

    public function removeRepository(string $name)
    {
        static::$repositories->remove(static::$repositories->search($name));
    }

    public function resetRepositories()
    {
        static::$repositories = new RepositoryCollection();
    }

    public function getCurrentComposerRepository(): Repository
    {
        return $this->repository;
    }
}