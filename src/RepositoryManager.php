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
use Composer\Factory;
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

    /**
     * @var bool
     */
    protected static $repositoriesLoaded = false;

    /**
     * {@inheritdoc}
     */
    public function activate(Composer $composer, IOInterface $io)
    {
        static::$composer = $composer;
        $configFile = static::$composer->getConfig()->get('home').'/config.json';
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
     * Gets all repositories.
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
        static::$repositories = RepositoryCollection::fromArray($repositories);
        try {
            $this->migrateFromOld();
        } catch (\Exception $exception) {
        }

        return static::$repositories;
    }

    protected function migrateFromOld()
    {
        if (count(static::$repositories) > 0) {
            return;
        }
        $homeConfigFile = ConfigPath::getUserConfigFile();
        $repositories = [];
        if (file_exists($homeConfigFile)) {
            $repositories = Utils::readJsonFile($homeConfigFile);
        } elseif (file_exists(ConfigPath::getDefaultConfigFile())) {
            $repositories = Utils::readJsonFile(ConfigPath::getDefaultConfigFile());
        }
        if ($repositories) {
            $repositories = RepositoryCollection::fromArray($repositories);
            static::$repositories = $repositories;
            static::$configSource->addConfigSetting('_repositories', $repositories->toArray());
        }
    }

    /**
     * Adds a repository.
     *
     * @param string $name
     * @param string $url
     *
     * @return Repository
     */
    public function addRepository($name, $url)
    {
        $repositories = $this->getRepositories();
        $repository = Repository::create([
            'name' => $name,
            'url' => $url,
        ]);
        $repositories->add($repository);
        static::$configSource->addConfigSetting('_repositories', $repositories->toArray());

        return $repository;
    }

    /**
     * Remove a repository.
     *
     * @param string $name
     */
    public function removeRepository($name)
    {
        $repository = $this->getRepositories()->findByName($name);
        $repositories = $this->getRepositories();
        $repositories->remove($repository);
        static::$configSource->addConfigSetting('_repositories', $repositories->toArray());
    }

    /**
     * Use repository.
     *
     * @param Repository $repository
     * @param bool       $modifyCurrent
     */
    public function useRepository(Repository $repository, $modifyCurrent = false)
    {
        if ($modifyCurrent) {
            $file = Factory::getComposerFile();
            $configFile = new JsonFile($file);
            if (!$configFile->exists()) {
                throw new \RuntimeException('Composer.json is not exists');
            }
            $configSource = new JsonConfigSource($configFile);
        } else {
            $configSource = static::$configSource;
        }
        $configSource->addRepository('packagist', [
            'type' => 'composer',
            'url' => $repository->getUrl(),
        ]);
    }

    /**
     * Gets current composer repository.
     *
     * @return Repository
     */
    public function getCurrentComposerRepository()
    {
        $composerRepos = array_filter(static::$composer->getConfig()->getRepositories(), function($repo){
            return 'composer' === $repo['type'];
        });
        $packagistRepoUrl = reset($composerRepos)['url'];
        foreach ($this->getRepositories() as $repository) {
            if (0 == strcasecmp($repository->getUrl(), $packagistRepoUrl)) {
                return $repository;
            }
        }

        return Repository::create([
            'url' => $packagistRepoUrl,
            'name' => 'composer',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getCapabilities()
    {
        return [
            CommandProvider::class => __CLASS__,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getCommands()
    {
        return [
            new Command\RepoCommand($this),
            new Command\ListCommand($this),
            new Command\AddCommand($this),
            new Command\RemoveCommand($this),
            new Command\UseCommand($this),
        ];
    }
}