<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driverClass' => 'Doctrine\\DBAL\\Driver\\PDOMySql\\Driver',
                'params' => [
                    'driver' => 'pdo_mysql',
                    'host' => 'localhost',
                    'port' => '3306',
                    'dbname' => 'zource',
                    'user' => '',
                    'password' => '',
                    'charset' => 'utf8',
                ],
                'doctrine_type_mappings' => [
                    'enum' => 'string',
                    'uuid_binary' => 'binary',
                ],
            ],
        ],
        'configuration' => [
            'orm_default' => [
                'naming_strategy' => 'UnderscoreNamingStrategy',
                'proxy_dir' => 'data/doctrine/orm/proxy',
                'proxy_namespace' => 'DoctrineORMModule\\Proxy',
                'types' => [
                    'uuid_binary' => 'Ramsey\\Uuid\\Doctrine\\UuidBinaryType',
                ],
            ],
        ],
        'migrations_configuration' => [
            'orm_default' => [
                'directory' => 'data/doctrine/orm/migrations',
                'name' => 'Zource Migrations',
                'namespace' => 'ZourceApplication\\Migration',
                'table' => 'migration',
            ],
        ],
    ],
    'zf-mvc-auth' => [
        'authentication' => [
            'adapters' => [
                'oauth2' => [
                    'adapter' => 'ZF\\MvcAuth\\Authentication\\OAuth2Adapter',
                    'storage' => [
                        'adapter' => 'pdo',
                        'dsn' => 'mysql:host=localhost;dbname=zource',
                        'route' => '',
                        'username' => '',
                        'password' => '',
                    ],
                ],
            ],
        ],
    ],
];
