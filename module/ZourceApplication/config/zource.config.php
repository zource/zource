<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication;

return [
    'controllers' => [
        'invokables' => [
            'ZourceApplication\\Controller\\Index' => 'ZourceApplication\\Controller\\IndexController',
        ],
    ],
    'router' => [
        'routes' => [
            'zf-apigility' => [
                'options' => [
                    'route' => '/api',
                ],
            ],
            'dashboard' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => 'ZourceApplication\\Controller\\Index',
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'abstract_factories' => [
            'Zend\\Cache\\Service\\StorageCacheAbstractServiceFactory',
            'Zend\\Db\\Adapter\\AdapterAbstractServiceFactory',
            'Zend\\Form\\FormAbstractServiceFactory',
            'Zend\\Log\\LoggerAbstractServiceFactory',
        ],
        'invokables' => [
            'UnderscoreNamingStrategy' => 'Doctrine\\ORM\\Mapping\\UnderscoreNamingStrategy',
        ],
    ],
    'translator' => [
        'translation_file_patterns' => [
            [
                'type' => 'phparray',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.php',
            ],
        ],
    ],
    'validators' => [
        'factories' => [
            'ZourceApplication\\Validator\\Uuid' => 'ZourceApplication\\Validator\\Service\\UuidFactory',
        ],
    ],
    'view_manager' => [
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => [
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'zource-application/index/index' => __DIR__ . '/../view/zource-application/index/index.phtml',
        ],
    ],
    'zource' => [
        'guard' => [
            'identity' => [
                'dashboard' => true,
            ],
        ],
    ],
];
