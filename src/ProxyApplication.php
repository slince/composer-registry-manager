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

use Symfony\Component\Console\Application;

class ProxyApplication extends Application
{
    /**
     * @var string
     */
    const VERSION = '2.4.0';

    protected static string $logo = <<<EOT
 _____   _____        ___  ___  
/  ___| |  _  \      /   |/   | 
| |     | |_| |     / /|   /| | 
| |     |  _  /    / / |__/ | | 
| |___  | | \ \   / /       | | 
\_____| |_|  \_\ /_/        |_| 


EOT;

    protected array $commands;

    public function __construct(array $commands)
    {
        $this->commands = $commands;
        parent::__construct('Composer Repository Manager', static::VERSION);
    }

    /**
     * {@inheritdoc}
     */
    public function getHelp(): string
    {
        return static::$logo.parent::getHelp();
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultCommands(): array
    {
        return array_merge(parent::getDefaultCommands(), $this->commands);
    }
}
