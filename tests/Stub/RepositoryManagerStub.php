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

    public function useRepository(Repository $repository, $isCurrent = false)
    {
        if ($isCurrent) {
            $this->currentRepository = $repository;
        } else {
            $this->repository = $repository;
        }
    }

    public function addRepository($name, $url, $location = null)
    {
        $repository = Repository::create([
            'name' => $name,
            'url' => $url,
            'location' => $location
        ]);
        static::$repositories->add($repository);
        return $repository;
    }

    public function getRepositories()
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

    public function removeRepository($name)
    {
        static::$repositories->remove(static::$repositories->search($name));
    }

    public function getCurrentComposerRepository()
    {
        return $this->repository;
    }
}