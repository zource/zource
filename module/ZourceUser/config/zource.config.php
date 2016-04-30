<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser;

return [
    'controllers' => [
        'factories' => [
            'ZourceUser\\Controller\\Authenticate' => 'ZourceUser\\Controller\\Service\\AuthenticateFactory',
        ],
    ],
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ => [
                'class' => 'Doctrine\\ORM\\Mapping\\Driver\\AnnotationDriver',
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/V1/Rest/Account',
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/V1/Rest/Email',
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/V1/Rest/Group',
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/V1/Rest/Identity',
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/V1/Rest/Session',
                ],
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ => __NAMESPACE__
                ],
            ],
        ],
    ],
    'router' => [
        'routes' => [
            'login' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/login',
                    'defaults' => [
                        'controller' => 'ZourceUser\\Controller\\Authenticate',
                        'action' => 'login',
                    ],
                ],
            ],
            'logout' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/logout',
                    'defaults' => [
                        'controller' => 'ZourceUser\\Controller\\Authenticate',
                        'action' => 'logout',
                    ],
                ],
            ],
        ],
    ],
    'validators' => [
        'factories' => [
            'ZourceUser\\Validator\\Directory' => 'ZourceUser\\Validator\\Service\\DirectoryFactory',
            'ZourceUser\\Validator\\IdentityNotExists' => 'ZourceUser\\Validator\\Service\\IdentityNotExistsFactory',
        ],
    ],
    'view_manager' => [
        'template_map' => [
            //'oauth/authorize' => __DIR__ . '/../view/oauth/authorize.phtml',
            //'oauth/receive-code' => __DIR__ . '/../view/oauth/receive-code.phtml',
            'zource-user/authenticate/login' => __DIR__ . '/../view/zource-user/authenticate/login.phtml',
        ],
    ],
];
