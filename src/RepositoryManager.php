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

use Composer\Composer;
use Composer\Config\ConfigSourceInterface;
use Composer\Config\JsonConfigSource;
use Composer\IO\IOInterface;
use Composer\Json\JsonFile;
use Composer\Plugin\Capability\CommandProvider;
use Composer\Plugin\Capable;
use Composer\Plugin\PluginInterface;
use Composer\Util\Silencer;

class RepositoryManager implements PluginInterface, Capable, CommandProvider
{
    /**
     * @var Composer
     */
    protected static $composer;

    /**
     * @var JsonFile
     */
    protected static $configFile;

    /**
     * @var ConfigSourceInterface
     */
    protected static $configSource;

    /**
     * @var RepositoryCollection
     */
    protected static $repositories;

    protected static $repositoriesLoaded = false;

    /**
     * {@inheritdoc}
     */
    public function activate(Composer $composer, IOInterface $io)
    {
        static::$composer = $composer;
        $configFile = static::$composer->getConfig()->get('home') . '/config.json';
        $this->prepareConfigSource(new JsonFile($configFile));
    }

    /**
     * {@inheritdoc}
     */
    protected function prepareConfigSource($configFile)
    {
        static::$configFile = $configFile;
        if (!static::$configFile->exists()) {
            touch(static::$configFile->getPath());
            static::$configFile->write(['config' => new \ArrayObject()]);
            Silencer::call('chmod', static::$configFile->getPath(), 0600);
        }
        static::$configSource = new JsonConfigSource(static::$configFile);
    }

    /**
     * Gets all repositories
     *
     * @return RepositoryCollection
     */
    public function getRepositories()
    {
        if (static::$repositoriesLoaded) {
            return static::$repositories;
        }
        $config = static::$configFile->read();
        if (!isset($config['config']['_repositories']) || !is_array($config['config']['_repositories'])) {
            $repositories = [];
        } else {
            $repositories = $config['config']['_repositories'];
        }
        static::$repositoriesLoaded = true;
        return static::$repositories = RepositoryCollection::fromArray($repositories);
    }

    /**
     * Adds a repository
     *
     * @param string $name
     * @param string $url
     */
    public function addRepository($name, $url)
    {
        $repositories = $this->getRepositories();
        $repositories->add(Repository::create([
            'name' => $name,
            'url' => $url
        ]));
        static::$configSource->addConfigSetting('_repositories', $repositories);
    }

    /**
     * Remove a repository
     *
     * @param string $name
     */
    public function removeRepository($name)
    {
        $repository = $this->getRepositories()->findByName($name);
        $repositories = $this->getRepositories()->remove($repository);
        static::$configSource->addConfigSetting('_repositories', $repositories);
    }

    public function useRepository(Repository $repository, $modifyCurrent = false)
    {

    }

    /**
     * Gets current composer repository
     *
     * @return Repository
     */
    public function getCurrentComposerRepository()
    {
        $composerRepos = array_filter(static::$composer->getConfig()->getRepositories(), function($repo){
            return $repo['type'] === 'composer';
        });
        $packagistRepoUrl = reset($composerRepos)['url'];
        foreach ($this->getRepositories() as $repository) {
            if (strcasecmp($repository->getUrl(), $packagistRepoUrl) == 0) {
                return $repository;
            }
        }
        return Repository::create([
            'url' => $packagistRepoUrl,
            'name' => 'composer'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getCapabilities()
    {
        return [
            CommandProvider::class => __CLASS__
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getCommands()
    {
        return [
            new Command\RepoCommand($this),
            new Command\AddCommand($this),
            new Command\RemoveCommand($this),
            new Command\UseCommand($this),
        ];
    }
}