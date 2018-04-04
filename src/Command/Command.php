<?php

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
    protected $repositoryManager;

    public function __construct(RepositoryManager $repositoryManager, $name = null)
    {
        $this->repositoryManager = $repositoryManager;
        parent::__construct($name);
    }
}