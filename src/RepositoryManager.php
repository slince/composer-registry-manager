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

use Composer\Composer;
use Composer\Config\JsonConfigSource;
use Composer\Factory;
use Composer\IO\IOInterface;
use Composer\Json\JsonFile;
use Composer\Plugin\Capability\CommandProvider;
use Composer\Plugin\Capable;
use Composer\Plugin\PluginInterface;
use Composer\Util\Silencer;
use Seld\JsonLint\ParsingException;

class RepositoryManager implements PluginInterface, Capable, CommandProvider
{
    /**
     * @var Composer
     */
    protected static Composer $composer;

    /**
     * @var JsonFile
     */
    protected static JsonFile $configFile;

    /**
     * Global config file source.
     *
     * @var JsonConfigSource
     */
    protected static JsonConfigSource $configSource;

    /**
     * Config file source of the project.
     *
     * @var JsonConfigSource|null
     */
    protected static ?JsonConfigSource $currentConfigSource = null;

    /**
     * @var RepositoryCollection
     */
    protected static RepositoryCollection $repositories;

    /**
     * @var bool
     */
    protected static bool $repositoriesLoaded = false;

    /**
     * {@inheritdoc}
     */
    public function activate(Composer $composer, IOInterface $io)
    {
        static::$composer = $composer;
        $file = static::$composer->getConfig()->get('home').'/config.json';
        $this->prepareConfigSource($file);
    }

    /**
     * {@inheritdoc}
     */
    public function deactivate(Composer $composer, IOInterface $io)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function uninstall(Composer $composer, IOInterface $io)
    {
    }

    /**
     * Initialize the config file.
     *
     * @param string $file
     * @throws \Exception
     */
    protected function prepareConfigSource(string $file)
    {
        $configFile = new JsonFile($file);
        if (!$configFile->exists()) {
            touch($configFile->getPath());
            $configFile->write(['config' => new \ArrayObject()]);
            Silencer::call('chmod', $configFile->getPath(), 0600);
        }
        static::$configFile = $configFile;
        static::$configSource = new JsonConfigSource($configFile);
    }

    /**
     * Gets all repositories.
     *
     * @return RepositoryCollection
     * @throws ParsingException
     */
    public function getRepositories(): RepositoryCollection
    {
        if (static::$repositoriesLoaded) {
            return static::$repositories;
        }
        static::$repositories = $this->loadRepositories();
        static::$repositoriesLoaded = true;
        return static::$repositories;
    }

    /**
     * Load repository from config file.
     *
     * @return RepositoryCollection
     * @throws ParsingException
     */
    protected function loadRepositories(): RepositoryCollection
    {
        $config = static::$configFile->read();
        $repositories = [];
        if (isset($config['config']['_repositories']) && is_array($config['config']['_repositories'])) {
            $repositories = $config['config']['_repositories'];
        }
        if (count($repositories) === 0) {
            $repositories = Utils::readJsonFile(Utils::getDefaultConfigFile());
        }
        return RepositoryCollection::fromArray($repositories);
    }


    /**
     * Adds a repository.
     *
     * @param string $name
     * @param string $url
     * @param string|null $location
     * @return Repository
     * @throws ParsingException
     */
    public function addRepository(string $name, string $url, string $location = null): Repository
    {
        $repository = Repository::create([
            'name' => $name,
            'url' => $url,
            'location' => $location
        ]);
        $this->getRepositories()->add($repository);
        static::$configSource->addConfigSetting('_repositories', $this->getRepositories()->toArray());
        return $repository;
    }

    /**
     * Remove a repository by the name.
     *
     * @param string $name
     * @throws ParsingException
     */
    public function removeRepository(string $name)
    {
        $repository = $this->getRepositories()->search($name);
        if (null === $repository) {
            throw new \InvalidArgumentException(sprintf('Cannot find the repository %s', $name));
        }
        $this->getRepositories()->remove($repository);
        static::$configSource->addConfigSetting('_repositories', $this->getRepositories()->toArray());
    }

    /**
     * Use the repository.
     *
     * @param Repository $repository
     * @param bool $modifyCurrent
     */
    public function useRepository(Repository $repository, bool $modifyCurrent = false)
    {
        $configSource = $modifyCurrent ? $this->getCurrentConfigSource() : static::$configSource;
        $configSource->addRepository('packagist', [
            'type' => 'composer',
            'url' => $repository->getUrl(),
        ]);
    }

    /**
     * Remove custom repositories and reset to default.
     */
    public function resetRepositories()
    {
        static::$configSource->removeConfigSetting('_repositories');
    }

    /**
     * Get the project config source.
     *
     * @return JsonConfigSource
     */
    protected function getCurrentConfigSource(): JsonConfigSource
    {
        if (static::$currentConfigSource) {
            return static::$currentConfigSource;
        }
        $file = Factory::getComposerFile();
        $configFile = new JsonFile($file);
        if (!$configFile->exists()) {
            throw new \RuntimeException('Composer.json is not exists in current dir');
        }
        return static::$currentConfigSource = new JsonConfigSource($configFile);
    }

    /**
     * Gets current composer repository.
     *
     * @return Repository
     * @throws ParsingException
     */
    public function getCurrentComposerRepository(): Repository
    {
        $composerRepos = array_filter(static::$composer->getConfig()->getRepositories(), fn($repo) => 'composer' === $repo['type']);
        $packagistRepoUrl = reset($composerRepos)['url'];
        foreach ($this->getRepositories() as $repository) {
            if (0 === strcasecmp($repository->getUrl(), $packagistRepoUrl)) {
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
    public function getCapabilities(): array
    {
        return [
            CommandProvider::class => __CLASS__,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getCommands(): array
    {
        return [
            new Command\RepoCommand($this),
            new Command\ListCommand($this),
            new Command\AddCommand($this),
            new Command\RemoveCommand($this),
            new Command\UseCommand($this),
            new Command\ResetCommand($this),
        ];
    }
}