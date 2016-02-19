<?php

/*
 * This file is part of the Jirro package.
 *
 * (c) Rendy Eko Prastiyo <rendyekoprastiyo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jirro\Component\DBAL\Container\ServiceProvider;

use League\Container\ServiceProvider;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Logging\DebugStack;

class DBALServiceProvider extends ServiceProvider
{
    protected $provides = [
        'dbal_connection_params',
        'db_connection',
    ];

    public function register()
    {
        $this->container['dbal_connection_params'] = function () {
            return $this->container->get('config')['dbal']['connection']['params'];
        };

        $this->container['db_connection'] = function () {
            $connectionParams = $this->container->get('dbal_connection_params');

            $debugStack = new DebugStack();

            $config = new Configuration();
            $config->setSQLLogger($debugStack);

            return DriverManager::getConnection($connectionParams, $config);
        };
    }
}
