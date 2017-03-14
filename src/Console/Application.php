<?php
/**
 * CRM library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Crm\Console;

use Symfony\Component\Console\Application as BaseApplication;

class Application extends BaseApplication
{
    /**
     * Application name
     * @var string
     */
    const NAME = 'Composer Registry Manager';

    public function __construct()
    {
        parent::__construct(static::NAME);
    }
}
