<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser;

use Zend\Authentication\AuthenticationService;
use Zend\Form\Form;
use ZourceUser\Authentication\OAuth\Service\StorageFactory;
use ZourceUser\Authentication\OAuth\Storage;
use ZourceUser\Authentication\Service\AuthenticationServiceFactory;
use ZourceUser\Authorization\Condition\Service\UserHasIdentityFactory;
use ZourceUser\Authorization\Condition\Service\UserHasRoleFactory;
use ZourceUser\InputFilter\Authenticate as AuthenticateInputFilter;
use ZourceUser\InputFilter\Service\AuthenticateFactory as AuthenticateInputFilterFactory;
use ZourceUser\Mvc\Controller\Authenticate;
use ZourceUser\Mvc\Controller\OAuth;
use ZourceUser\Mvc\Controller\Service\AuthenticateFactory;
use ZourceUser\Mvc\Controller\Service\OAuthFactory;
use ZourceUser\Mvc\Controller\Service\SettingsFactory;
use ZourceUser\Mvc\Controller\Settings;
use ZourceUser\Validator\Directory;
use ZourceUser\Validator\IdentityNotExists;
use ZourceUser\Validator\Service\DirectoryFactory;
use ZourceUser\Validator\Service\IdentityNotExistsFactory;
use ZourceUser\TaskService\OAuth as OAuthTaskService;
use ZourceUser\TaskService\Service\OAuthFactory as OAuthTaskServiceFactory;

return [
    'controllers' => [
        'factories' => [
            Authenticate::class => AuthenticateFactory::class,
            OAuth::class => OAuthFactory::class,
            Settings::class => SettingsFactory::class,
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
            'type' => Form::class,
            'hydrator' => 'ClassMethods',
            'input_filter' => AuthenticateInputFilter::class,
            'elements' => [
                'csrf' => [
                    'spec' => [
                        'type' => 'Csrf',
                        'name' => 'token',
                    ],
                ],
                'identity' => [
                    'spec' => [
                        'type' => 'Text',
                        'name' => 'identity',
                        'options' => [
                            'label' => 'loginFormInputIdentityLabel',
                        ],
                    ],
                ],
                'credential' => [
                    'spec' => [
                        'type' => 'Password',
                        'name' => 'credential',
                        'options' => [
                            'label' => 'loginFormInputCredentialLabel',
                        ],
                    ],
                ],
                'submit' => [
                    'spec' => [
                        'type' => 'Submit',
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
            AuthenticateInputFilter::class => AuthenticateInputFilterFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'login' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/login',
                    'defaults' => [
                        'controller' => Authenticate::class,
                        'action' => 'login',
                    ],
                ],
            ],
            'logout' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/logout',
                    'defaults' => [
                        'controller' => Authenticate::class,
                        'action' => 'logout',
                    ],
                ],
            ],
            'oauth' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/oauth',
                    'defaults' => [
                        'controller' => OAuth::class,
                    ],
                ],
                'child_routes' => [
                    'authorize' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => '/authorize',
                            'defaults' => [
                                'action' => 'authorize',
                            ],
                        ],
                    ],
                    'token' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => '/token',
                            'defaults' => [
                                'action' => 'token',
                            ],
                        ],
                    ],
                ],
            ],
            'settings' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/settings',
                    'defaults' => [
                        'controller' => Settings::class,
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            AuthenticationService::class => AuthenticationServiceFactory::class,
            OAuthTaskService::class => OAuthTaskServiceFactory::class,
            Storage::class => StorageFactory::class,
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
            Directory::class => DirectoryFactory::class,
            IdentityNotExists::class => IdentityNotExistsFactory::class,
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
            'UserHasIdentity' => UserHasIdentityFactory::class,
            'UserHasRole' => UserHasRoleFactory::class,
        ],
    ],
    'zource_guard' => [
        'identity' => [
            'login' => false,
            'logout' => true,
            'oauth/authorize' => true,
            'oauth/token' => false,
            'oauth' => false,
            'settings' => true,
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
                                'route' => 'settings',
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
        'storage' => Storage::class,
        'grant_types' => array(
            'client_credentials' => true,
            'authorization_code' => true,
            'password' => true,
            'refresh_token' => true,
            'jwt' => false,
        ),
    ],
];
