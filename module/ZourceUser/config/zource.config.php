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
use Zend\Crypt\Password\Bcrypt;
use Zend\Crypt\Password\PasswordInterface;
use ZourceUser\Authentication\OAuth\Service\StorageFactory;
use ZourceUser\Authentication\OAuth\Storage;
use ZourceUser\Authentication\Service\AuthenticationServiceFactory;
use ZourceUser\Authorization\Condition\Service\UserHasIdentityFactory;
use ZourceUser\Authorization\Condition\Service\UserHasRoleFactory;
use ZourceUser\Form\Account as AccountForm;
use ZourceUser\Form\Authenticate as AuthenticateForm;
use ZourceUser\Form\CreateApplication as CreateApplicationForm;
use ZourceUser\Form\Profile as ProfileForm;
use ZourceUser\Form\RequestPassword as RequestPasswordForm;
use ZourceUser\Form\ResetPassword as ResetPasswordForm;
use ZourceUser\Form\VerifyCode as VerifyCodeForm;
use ZourceUser\InputFilter\Account as AccountInputFilter;
use ZourceUser\InputFilter\Authenticate as AuthenticateInputFilter;
use ZourceUser\InputFilter\CreateApplication as CreateApplicationInputFilter;
use ZourceUser\InputFilter\Profile as ProfileInputFilter;
use ZourceUser\InputFilter\RequestPassword as RequestPasswordInputFilter;
use ZourceUser\InputFilter\ResetPassword as ResetPasswordInputFilter;
use ZourceUser\InputFilter\Service\AuthenticateFactory as AuthenticateInputFilterFactory;
use ZourceUser\InputFilter\VerifyCode as VerifyCodeInputFilter;
use ZourceUser\Mvc\Controller\Account;
use ZourceUser\Mvc\Controller\Application;
use ZourceUser\Mvc\Controller\Authenticate;
use ZourceUser\Mvc\Controller\DeveloperApplication;
use ZourceUser\Mvc\Controller\Email;
use ZourceUser\Mvc\Controller\Notification;
use ZourceUser\Mvc\Controller\OAuth;
use ZourceUser\Mvc\Controller\Plugin\Service\AccountFactory as AccountPluginFactory;
use ZourceUser\Mvc\Controller\Plugin\Service\IdentityFactory;
use ZourceUser\Mvc\Controller\Profile;
use ZourceUser\Mvc\Controller\RecoveryCodes;
use ZourceUser\Mvc\Controller\Request;
use ZourceUser\Mvc\Controller\Security;
use ZourceUser\Mvc\Controller\Service\AccountFactory;
use ZourceUser\Mvc\Controller\Service\ApplicationFactory;
use ZourceUser\Mvc\Controller\Service\AuthenticateFactory;
use ZourceUser\Mvc\Controller\Service\DeveloperApplicationFactory;
use ZourceUser\Mvc\Controller\Service\EmailFactory;
use ZourceUser\Mvc\Controller\Service\NotificationFactory;
use ZourceUser\Mvc\Controller\Service\OAuthFactory;
use ZourceUser\Mvc\Controller\Service\ProfileFactory;
use ZourceUser\Mvc\Controller\Service\RequestFactory;
use ZourceUser\Mvc\Controller\Service\SecurityFactory;
use ZourceUser\Mvc\Controller\Service\TwoFactorAuthenticationFactory;
use ZourceUser\Mvc\Controller\TwoFactorAuthentication;
use ZourceUser\TaskService\Application as ApplicationService;
use ZourceUser\TaskService\OAuth as OAuthTaskService;
use ZourceUser\TaskService\PasswordChanger;
use ZourceUser\TaskService\Service\ApplicationFactory as ApplicationServiceFactory;
use ZourceUser\TaskService\Service\OAuthFactory as OAuthTaskServiceFactory;
use ZourceUser\TaskService\Service\PasswordChangerFactory;
use ZourceUser\TaskService\Service\TwoFactorAuthenticationFactory as TwoFactorAuthenticationServiceFactory;
use ZourceUser\TaskService\TwoFactorAuthentication as TwoFactorAuthenticationService;
use ZourceUser\Validator\Directory;
use ZourceUser\Validator\IdentityNotExists;
use ZourceUser\Validator\Service\DirectoryFactory;
use ZourceUser\Validator\Service\IdentityNotExistsFactory;

return [
    'controllers' => [
        'factories' => [
            Account::class => AccountFactory::class,
            Application::class => ApplicationFactory::class,
            Authenticate::class => AuthenticateFactory::class,
            DeveloperApplication::class => DeveloperApplicationFactory::class,
            Email::class => EmailFactory::class,
            Notification::class => NotificationFactory::class,
            OAuth::class => OAuthFactory::class,
            Profile::class => ProfileFactory::class,
            Request::class => RequestFactory::class,
            Security::class => SecurityFactory::class,
            TwoFactorAuthentication::class => TwoFactorAuthenticationFactory::class,
        ],
    ],
    'controller_plugins' => [
        'factories' => [
            'zourceAccount' => AccountPluginFactory::class,
            'zourceIdentity' => IdentityFactory::class,
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
        AccountForm::class => [
            'type' => AccountForm::class,
            'hydrator' => 'ClassMethods',
            'input_filter' => AccountInputFilter::class,
        ],
        AuthenticateForm::class => [
            'type' => AuthenticateForm::class,
            'hydrator' => 'ClassMethods',
            'input_filter' => AuthenticateInputFilter::class,
        ],
        CreateApplicationForm::class => [
            'type' => CreateApplicationForm::class,
            'hydrator' => 'ClassMethods',
            'input_filter' => CreateApplicationInputFilter::class,
        ],
        ProfileForm::class => [
            'type' => ProfileForm::class,
            'hydrator' => 'ClassMethods',
            'input_filter' => ProfileInputFilter::class,
        ],
        RequestPasswordForm::class => [
            'type' => RequestPasswordForm::class,
            'hydrator' => 'ClassMethods',
            'input_filter' => RequestPasswordInputFilter::class,
        ],
        ResetPasswordForm::class => [
            'type' => ResetPasswordForm::class,
            'hydrator' => 'ClassMethods',
            'input_filter' => ResetPasswordInputFilter::class,
        ],
        VerifyCodeForm::class => [
            'type' => VerifyCodeForm::class,
            'hydrator' => 'ClassMethods',
            'input_filter' => VerifyCodeInputFilter::class,
        ],
    ],
    'input_filters' => [
        'factories' => [
            AuthenticateInputFilter::class => AuthenticateInputFilterFactory::class,
        ],
        'invokables' => [
            AccountInputFilter::class => AccountInputFilter::class,
            CreateApplicationInputFilter::class => CreateApplicationInputFilter::class,
            ProfileInputFilter::class => ProfileInputFilter::class,
            RequestPasswordInputFilter::class => RequestPasswordInputFilter::class,
            ResetPasswordInputFilter::class => ResetPasswordInputFilter::class,
            VerifyCodeInputFilter::class => VerifyCodeInputFilter::class,
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
            'login-tfa' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/login/tfa',
                    'defaults' => [
                        'controller' => Authenticate::class,
                        'action' => 'login-tfa',
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
            'request' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/request',
                ],
                'child_routes' => [
                    'password' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => '/password',
                            'defaults' => [
                                'controller' => Request::class,
                                'action' => 'password',
                            ],
                        ],
                    ],
                    'reset-password' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/password/reset[/:code]',
                            'defaults' => [
                                'controller' => Request::class,
                                'action' => 'reset-password',
                            ],
                            'constraints' => [
                                'code' => '[a-z0-9]{32}',
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
                'child_routes' => [
                    'account' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => '/account',
                            'defaults' => [
                                'controller' => Account::class,
                                'action' => 'index',
                            ],
                        ],
                    ],
                    'applications' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => '/applications',
                            'defaults' => [
                                'controller' => Application::class,
                                'action' => 'index',
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'create' => [
                                'type' => 'Literal',
                                'options' => [
                                    'route' => '/create',
                                    'defaults' => [
                                        'controller' => DeveloperApplication::class,
                                        'action' => 'create',
                                    ],
                                ],
                            ],
                            'update' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/update/:id',
                                    'defaults' => [
                                        'controller' => DeveloperApplication::class,
                                        'action' => 'update',
                                    ],
                                ],
                            ],
                            'delete' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/delete/:id',
                                    'defaults' => [
                                        'controller' => DeveloperApplication::class,
                                        'action' => 'delete',
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'email' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => '/email',
                            'defaults' => [
                                'controller' => Email::class,
                                'action' => 'index',
                            ],
                        ],
                    ],
                    'notifications' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => '/notifications',
                            'defaults' => [
                                'controller' => Notification::class,
                                'action' => 'index',
                            ],
                        ],
                    ],
                    'profile' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => '/profile',
                            'defaults' => [
                                'controller' => Profile::class,
                                'action' => 'index',
                            ],
                        ],
                    ],
                    'security' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => '/security',
                            'defaults' => [
                                'controller' => Security::class,
                                'action' => 'index',
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'recovery-codes' => [
                                'type' => 'Literal',
                                'options' => [
                                    'route' => '/2fa/recovery-codes',
                                    'defaults' => [
                                        'controller' => RecoveryCodes::class,
                                        'action' => 'index',
                                    ],
                                ],
                            ],
                            'recovery-codes-download' => [
                                'type' => 'Literal',
                                'options' => [
                                    'route' => '/2fa/recovery-codes/download',
                                    'defaults' => [
                                        'controller' => RecoveryCodes::class,
                                        'action' => 'download',
                                    ],
                                ],
                            ],
                            'revoke-session' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/revoke-session/:id',
                                    'defaults' => [
                                        'action' => 'revokeSession',
                                    ],
                                ],
                            ],
                            'tfa-enable' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/2fa/enable',
                                    'defaults' => [
                                        'controller' => TwoFactorAuthentication::class,
                                        'action' => 'enable',
                                    ],
                                ],
                            ],
                            'tfa-disable' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/2fa/disable',
                                    'defaults' => [
                                        'controller' => TwoFactorAuthentication::class,
                                        'action' => 'disable',
                                    ],
                                ],
                            ],
                            'tfa-image' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/2fa/image',
                                    'defaults' => [
                                        'controller' => TwoFactorAuthentication::class,
                                        'action' => 'render-qr-code',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            AuthenticationService::class => AuthenticationServiceFactory::class,
            ApplicationService::class => ApplicationServiceFactory::class,
            OAuthTaskService::class => OAuthTaskServiceFactory::class,
            PasswordChanger::class => PasswordChangerFactory::class,
            Storage::class => StorageFactory::class,
            TwoFactorAuthenticationService::class => TwoFactorAuthenticationServiceFactory::class,
        ],
        'invokables' => [
            PasswordInterface::class => Bcrypt::class,
        ],
    ],
    'session_containers' => [
        'ZourceUserSessionAuthenticate',
        'ZourceUserSession2FA',
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
            'zource-user/account/index' => __DIR__ . '/../view/zource-user/account/index.phtml',
            'zource-user/application/index' => __DIR__ . '/../view/zource-user/application/index.phtml',
            'zource-user/authenticate/login' => __DIR__ . '/../view/zource-user/authenticate/login.phtml',
            'zource-user/authenticate/login-tfa' => __DIR__ . '/../view/zource-user/authenticate/login-tfa.phtml',
            'zource-user/developer-application/create' => __DIR__ . '/../view/zource-user/developer-application/create.phtml',
            'zource-user/developer-application/update' => __DIR__ . '/../view/zource-user/developer-application/update.phtml',
            'zource-user/email/index' => __DIR__ . '/../view/zource-user/email/index.phtml',
            'zource-user/notification/index' => __DIR__ . '/../view/zource-user/notification/index.phtml',
            'zource-user/o-auth/authorize' => __DIR__ . '/../view/zource-user/o-auth/authorize.phtml',
            'zource-user/o-auth/receive-code' => __DIR__ . '/../view/zource-user/o-auth/receive-code.phtml',
            'zource-user/profile/index' => __DIR__ . '/../view/zource-user/profile/index.phtml',
            'zource-user/request/password' => __DIR__ . '/../view/zource-user/request/password.phtml',
            'zource-user/request/reset-password' => __DIR__ . '/../view/zource-user/request/reset-password.phtml',
            'zource-user/security/index' => __DIR__ . '/../view/zource-user/security/index.phtml',
            'zource-user/two-factor-authentication/disable' => __DIR__ . '/../view/zource-user/two-factor-authentication/disable.phtml',
            'zource-user/two-factor-authentication/enable' => __DIR__ . '/../view/zource-user/two-factor-authentication/enable.phtml',
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
            'login-tfa' => false,
            'logout' => true,
            'oauth/authorize' => true,
            'oauth/token' => false,
            'oauth' => false,
            'request/password' => false,
            'request/reset-password' => false,
            'settings/*' => true,
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
                                'label' => 'topBarProfileMenuHeader',
                            ],
                        ],
                        'profile' => [
                            'type' => 'label',
                            'priority' => 200,
                            'options' => [
                                'label' => 'topBarProfileMenuViewProfile',
                                'route' => 'settings/profile',
                            ],
                        ],
                        'settings' => [
                            'type' => 'label',
                            'priority' => 300,
                            'options' => [
                                'label' => 'topBarProfileMenuSettings',
                                'route' => 'settings/profile',
                            ],
                        ],
                        'admin' => [
                            'type' => 'label',
                            'priority' => 400,
                            'options' => [
                                'label' => 'topBarProfileMenuAdministration',
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
                            'priority' => 500,
                        ],
                        'logout' => [
                            'type' => 'label',
                            'priority' => 600,
                            'options' => [
                                'label' => 'topBarProfileMenuLogout',
                                'route' => 'logout',
                            ],
                        ],
                    ],
                ],
            ],
        ],
        'user-settings' => [
            'items' => [
                'header' => [
                    'type' => 'header',
                    'priority' => 100,
                    'options' => [
                        'label' => 'Personal Settings',
                    ],
                ],
                'profile' => [
                    'type' => 'label',
                    'priority' => 200,
                    'options' => [
                        'label' => 'userSettingsMenuProfile',
                        'route' => 'settings/profile',
                    ],
                ],
                'account' => [
                    'type' => 'label',
                    'priority' => 300,
                    'options' => [
                        'label' => 'userSettingsMenuAccount',
                        'route' => 'settings/account',
                    ],
                ],
                'emails' => [
                    'type' => 'label',
                    'priority' => 400,
                    'options' => [
                        'label' => 'userSettingsMenuEmails',
                        'route' => 'settings/email',
                    ],
                ],
                'notifications' => [
                    'type' => 'label',
                    'priority' => 500,
                    'options' => [
                        'label' => 'userSettingsMenuNotifications',
                        'route' => 'settings/notifications',
                    ],
                ],
                'security' => [
                    'type' => 'label',
                    'priority' => 600,
                    'options' => [
                        'label' => 'userSettingsMenuSecurity',
                        'route' => 'settings/security',
                    ],
                ],
                'applications' => [
                    'type' => 'label',
                    'priority' => 700,
                    'options' => [
                        'label' => 'userSettingsMenuApplications',
                        'route' => 'settings/applications',
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
