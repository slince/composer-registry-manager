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

namespace Slince\Crm\Command;

use Composer\Command\BaseCommand;
use Slince\Crm\RepositoryManager;

class Command extends BaseCommand
{
    /**
     * @var RepositoryManager
     */
    protected RepositoryManager $repositoryManager;

    public function __construct(RepositoryManager $repositoryManager, ?string $name = null)
    {
        $this->repositoryManager = $repositoryManager;
        parent::__construct($name);
    }

    /**
     * Return the repo manager.
     *
     * @return RepositoryManager
     */
    public function getRepositoryManager(): RepositoryManager
    {
        return $this->repositoryManager;
    }
}