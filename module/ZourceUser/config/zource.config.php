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
            'ZourceUser\\Mvc\\Controller\\Authenticate' => 'ZourceUser\\Mvc\\Controller\\Service\\AuthenticateFactory',
            'ZourceUser\\Mvc\\Controller\\OAuth' => 'ZourceUser\\Mvc\\Controller\\Service\\OAuthFactory',
        ],
    ],
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ => [
                'class' => 'Doctrine\\ORM\\Mapping\\Driver\\AnnotationDriver',
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity',
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
    'forms' => [
        'ZourceUser\\Form\\Authenticate' => [
            'type' => 'Zend\\Form\\Form',
            'hydrator' => 'ClassMethods',
            'input_filter' => 'ZourceUser\\InputFilter\\Authenticate',
            'elements' => [
                'csrf' => [
                    'spec' => [
                        'type' => 'Zend\\Form\\Element\\Csrf',
                        'name' => 'token',
                    ],
                ],
                'identity' => [
                    'spec' => [
                        'type' => 'Zend\\Form\\Element\\Text',
                        'name' => 'identity',
                        'options' => [
                            'label' => 'loginFormInputIdentityLabel',
                        ],
                    ],
                ],
                'credential' => [
                    'spec' => [
                        'type' => 'Zend\\Form\\Element\\Password',
                        'name' => 'credential',
                        'options' => [
                            'label' => 'loginFormInputCredentialLabel',
                        ],
                    ],
                ],
                'submit' => [
                    'spec' => [
                        'type' => 'Zend\\Form\\Element\\Submit',
                        'name' => 'submit',
                        'attributes' => [
                            'value' => 'loginFormInputSubmitValue',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'input_filters' => [
        'factories' => [
            'ZourceUser\\InputFilter\\Authenticate' => 'ZourceUser\\InputFilter\\Service\\AuthenticateFactory',
        ],
    ],
    'router' => [
        'routes' => [
            'login' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/login',
                    'defaults' => [
                        'controller' => 'ZourceUser\\Mvc\\Controller\\Authenticate',
                        'action' => 'login',
                    ],
                ],
            ],
            'logout' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/logout',
                    'defaults' => [
                        'controller' => 'ZourceUser\\Mvc\\Controller\\Authenticate',
                        'action' => 'logout',
                    ],
                ],
            ],
            'oauth' => [
                'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
                'options' => [
                    'route' => '/oauth',
                    'defaults' => [
                        'controller' => 'ZourceUser\\Mvc\\Controller\\OAuth',
                    ],
                ],
                'child_routes' => [
                    'authorize' => [
                        'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
                        'options' => [
                            'route' => '/authorize',
                            'defaults' => [
                                'action' => 'authorize',
                            ],
                        ],
                    ],
                    'token' => [
                        'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
                        'options' => [
                            'route' => '/token',
                            'defaults' => [
                                'action' => 'token',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            'Zend\\Authentication\\AuthenticationService' => 'ZourceUser\\Authentication\\Service\\AuthenticationServiceFactory',
            'ZourceUser\\TaskService\\OAuth' => 'ZourceUser\\TaskService\\Service\\OAuthFactory',
            'ZourceUser\\Authentication\\OAuth\\Storage' => 'ZourceUser\\Authentication\\OAuth\\Service\\StorageFactory',
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
            'ZourceUser\\Validator\\Directory' => 'ZourceUser\\Validator\\Service\\DirectoryFactory',
            'ZourceUser\\Validator\\IdentityNotExists' => 'ZourceUser\\Validator\\Service\\IdentityNotExistsFactory',
        ],
    ],
    'view_manager' => [
        'template_map' => [
            'zource-user/authenticate/login' => __DIR__ . '/../view/zource-user/authenticate/login.phtml',
            'zource-user/o-auth/authorize' => __DIR__ . '/../view/zource-user/o-auth/authorize.phtml',
            'zource-user/o-auth/receive-code' => __DIR__ . '/../view/zource-user/o-auth/receive-code.phtml',
        ],
    ],
    'zource_conditions' => [
        'factories' => [
            'UserHasIdentity' => 'ZourceUser\\Authorization\\Condition\\Service\\UserHasIdentityFactory',
            'UserHasRole' => 'ZourceUser\\Authorization\\Condition\\Service\\UserHasRoleFactory',
        ],
    ],
    'zource_guard' => [
        'identity' => [
            'login' => false,
            'logout' => true,
            'oauth/authorize' => true,
            'oauth/token' => false,
            'oauth' => false,
            'zf-apigility/*' => false,
        ],
        'routes' => [
        ],
    ],
    'zource_nav' => [
        'top-bar-secondary' => [
            'items' => [
                'login' => [
                    'type' => 'label',
                    'priority' => 1000,
                    'options' => [
                        'label' => 'layoutTopMenuLogin',
                        'route' => 'login',
                    ],
                    'conditions' => [
                        'user-has-identity' => [
                            'type' => 'UserHasIdentity',
                            'invert' => true,
                            'options' => [],
                        ],
                    ],
                ],
                'profile' => [
                    'type' => 'dropdown',
                    'priority' => 1000,
                    'options' => [
                        'label' => 'layoutTopMenuProfile',
                        'route' => 'dashboard',
                    ],
                    'conditions' => [
                        'user-has-identity' => [
                            'type' => 'UserHasIdentity',
                            'options' => [],
                        ],
                    ],
                    'child_items' => [
                        'header' => [
                            'type' => 'header',
                            'priority' => 100,
                            'options' => [
                                'label' => 'layoutTopMenuProfileHeader',
                            ],
                        ],
                        'settings' => [
                            'type' => 'label',
                            'priority' => 1000,
                            'options' => [
                                'label' => 'layoutTopMenuSettings',
                                'route' => 'logout',
                            ],
                        ],
                        'admin' => [
                            'type' => 'label',
                            'priority' => 2000,
                            'options' => [
                                'label' => 'layoutTopMenuAdmin',
                                'route' => 'logout',
                            ],
                            'conditions' => [
                                'user-has-identity' => [
                                    'type' => 'UserHasRole',
                                    'options' => [
                                        'role' => 'admin',
                                    ],
                                ],
                            ],
                        ],
                        'separator' => [
                            'type' => 'separator',
                            'priority' => 3000,
                        ],
                        'logout' => [
                            'type' => 'label',
                            'priority' => 4000,
                            'options' => [
                                'label' => 'layoutTopMenuLogout',
                                'route' => 'logout',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'zource_oauth' => [
        'server_options' => [
            'access_lifetime' => 3600,
            'allow_implicit' => true,
            'enforce_state' => true,
        ],
    ],
    'zf-oauth2' => [
        'storage' => 'ZourceUser\\Authentication\\OAuth\\Storage',
        'grant_types' => array(
            'client_credentials' => true,
            'authorization_code' => true,
            'password' => true,
            'refresh_token' => true,
            'jwt' => false,
        ),
    ],
];
