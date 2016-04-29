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
            'Zend\\Log\\LoggerAbstractServiceFactory',
        ],
        'invokables' => [
            'UnderscoreNamingStrategy' => 'Doctrine\\ORM\\Mapping\\UnderscoreNamingStrategy',
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
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
            //'oauth/authorize' => __DIR__ . '/../view/oauth/authorize.phtml',
            //'oauth/receive-code' => __DIR__ . '/../view/oauth/receive-code.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
