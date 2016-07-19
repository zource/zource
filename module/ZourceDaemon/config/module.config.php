<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceDaemon;

use ZourceDaemon\Worker\Noop;

return [
    'console' => [
        'router' => [
            'routes' => [
                'daemon-run' => [
                    'options' => [
                        'route' => 'zource:daemon:run',
                        'defaults' => [
                            'controller' => Mvc\Controller\Daemon::class,
                            'action' => 'run',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Mvc\Controller\Daemon::class => Mvc\Controller\Service\DaemonFactory::class,
        ],
    ],
    'controller_plugins' => [
        'factories' => [
            'zourceDaemon' => Mvc\Controller\Plugin\Service\DaemonFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            TaskService\Daemon::class => TaskService\Service\DaemonFactory::class,
        ],
        'invokables' => [
            Service\WorkerManager::class => Service\WorkerManager::class,
        ],
    ],
    'zource_daemon' => [
        'host' => '127.0.0.1',
        'port' => 11300,
        'lifetime' => 3600,
        'timeout' => 5,
        'interval' => 100,
        'tubes' => [
            'zource',
        ],
    ],
    'zource_workers' => [
        'invokables' => [
            Noop::class => Noop::class,
        ],
    ],
];
