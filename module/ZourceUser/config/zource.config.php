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
use ZourceUser\Authorization\Condition\Service\NotificationsExistFactory;
use ZourceUser\Authorization\Condition\Service\UserHasIdentityFactory;
use ZourceUser\Authorization\Condition\Service\UserHasRoleFactory;
use ZourceUser\Entity\Account as AccountEntity;
use ZourceUser\Entity\AccountInterface;
use ZourceUser\Entity\Identity as IdentityEntity;
use ZourceUser\Entity\IdentityInterface;
use ZourceUser\InputFilter\Account as AccountInputFilter;
use ZourceUser\InputFilter\AddEmail as AddEmailInputFilter;
use ZourceUser\InputFilter\Authenticate as AuthenticateInputFilter;
use ZourceUser\InputFilter\ChangeIdentity as ChangeIdentityInputFilter;
use ZourceUser\InputFilter\CreateApplication as CreateApplicationInputFilter;
use ZourceUser\InputFilter\Profile as ProfileInputFilter;
use ZourceUser\InputFilter\RequestPassword as RequestPasswordInputFilter;
use ZourceUser\InputFilter\ResetPassword as ResetPasswordInputFilter;
use ZourceUser\InputFilter\Service\AuthenticateFactory as AuthenticateInputFilterFactory;
use ZourceUser\InputFilter\VerifyCode as VerifyCodeInputFilter;
use ZourceUser\InputFilter\VerifyEmail as VerifyEmailInputFilter;
use ZourceUser\Mvc\Controller\Account;
use ZourceUser\Mvc\Controller\AdminAccounts as AdminAccountsController;
use ZourceUser\Mvc\Controller\AdminGroups as AdminGroupsController;
use ZourceUser\Mvc\Controller\AdminRoles as AdminRolesController;
use ZourceUser\Mvc\Controller\Application;
use ZourceUser\Mvc\Controller\Authenticate;
use ZourceUser\Mvc\Controller\Console as ConsoleController;
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
use ZourceUser\Mvc\Controller\Service\AdminAccountsFactory;
use ZourceUser\Mvc\Controller\Service\AdminGroupsFactory;
use ZourceUser\Mvc\Controller\Service\AdminRolesFactory;
use ZourceUser\Mvc\Controller\Service\ApplicationFactory;
use ZourceUser\Mvc\Controller\Service\AuthenticateFactory;
use ZourceUser\Mvc\Controller\Service\ConsoleFactory as ConsoleControllerFactory;
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
use ZourceUser\TaskService\Email as EmailTaskService;
use ZourceUser\TaskService\OAuth as OAuthTaskService;
use ZourceUser\TaskService\PasswordChanger;
use ZourceUser\TaskService\Roles;
use ZourceUser\TaskService\Service\ApplicationFactory as ApplicationServiceFactory;
use ZourceUser\TaskService\Service\EmailFactory as EmailTaskServiceFactory;
use ZourceUser\TaskService\Service\OAuthFactory as OAuthTaskServiceFactory;
use ZourceUser\TaskService\Service\PasswordChangerFactory;
use ZourceUser\TaskService\Service\RolesFactory;
use ZourceUser\TaskService\Service\TwoFactorAuthenticationFactory as TwoFactorAuthenticationServiceFactory;
use ZourceUser\TaskService\TwoFactorAuthentication as TwoFactorAuthenticationService;
use ZourceUser\UI\Navigation\Item\LoggedInAs;
use ZourceUser\UI\Navigation\Item\Service\LoggedInAsFactory;
use ZourceUser\Validator\Directory;
use ZourceUser\Validator\IdentityNotExists;
use ZourceUser\Validator\Service\DirectoryFactory;
use ZourceUser\Validator\Service\IdentityNotExistsFactory;
use ZourceUser\Validator\Service\VerifyEmailCodeFactory;
use ZourceUser\Validator\VerifyEmailCode;

return [
    'console' => [
        'router' => [
            'routes' => [
                'account-create' => [
                    'options' => [
                        'route' => 'zource:account:create [--first-name=] [--family-name=] [--credential=]',
                        'defaults' => [
                            'controller' => ConsoleController::class,
                            'action' => 'accountCreate',
                        ],
                    ],
                ],
                'account-delete' => [
                    'options' => [
                        'route' => 'zource:account:delete <id>',
                        'defaults' => [
                            'controller' => ConsoleController::class,
                            'action' => 'accountDelete',
                        ],
                    ],
                ],
                'account-list' => [
                    'options' => [
                        'route' => 'zource:account:list',
                        'defaults' => [
                            'controller' => ConsoleController::class,
                            'action' => 'accountList',
                        ],
                    ],
                ],
                'identity-create' => [
                    'options' => [
                        'route' => 'zource:identity:create <account> <directory> <identity>',
                        'defaults' => [
                            'controller' => ConsoleController::class,
                            'action' => 'identityCreate',
                        ],
                    ],
                ],
                'identity-delete' => [
                    'options' => [
                        'route' => 'zource:identity:delete <id>',
                        'defaults' => [
                            'controller' => ConsoleController::class,
                            'action' => 'identityDelete',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Account::class => AccountFactory::class,
            AdminAccountsController::class => AdminAccountsFactory::class,
            AdminGroupsController::class => AdminGroupsFactory::class,
            AdminRolesController::class => AdminRolesFactory::class,
            Application::class => ApplicationFactory::class,
            Authenticate::class => AuthenticateFactory::class,
            ConsoleController::class => ConsoleControllerFactory::class,
            DeveloperApplication::class => DeveloperApplicationFactory::class,
            Email::class => EmailFactory::class,
            Mvc\Controller\AdminDirectories::class => Mvc\Controller\Service\AdminDirectoriesFactory::class,
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
                ],
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ => __NAMESPACE__
                ],
            ],
        ],
        'entity_resolver' => [
            'orm_default' => [
                'resolvers' => [
                    AccountInterface::class => AccountEntity::class,
                    IdentityInterface::class => IdentityEntity::class,
                ],
            ],
        ],
        'fixture' => [
            __NAMESPACE__ => __DIR__ . '/../src/' . __NAMESPACE__ . '/Fixture',
        ],
    ],
    'forms' => [
        Form\Account::class => [
            'type' => Form\Account::class,
            'hydrator' => 'ClassMethods',
            'input_filter' => AccountInputFilter::class,
        ],
        Form\AddEmail::class => [
            'type' => Form\AddEmail::class,
            'hydrator' => 'ClassMethods',
            'input_filter' => AddEmailInputFilter::class,
        ],
        Form\AdminAccount::class => [
            'type' => Form\AdminAccount::class,
            'hydrator' => 'ClassMethods',
            'input_filter' => InputFilter\AdminAccount::class,
        ],
        Form\AdminInvite::class => [
            'type' => Form\AdminInvite::class,
            'hydrator' => 'ClassMethods',
            'input_filter' => InputFilter\AdminInvite::class,
        ],
        Form\AdminGroup::class => [
            'type' => Form\AdminGroup::class,
            'hydrator' => 'ClassMethods',
            'input_filter' => InputFilter\AdminGroup::class,
        ],
        Form\AdminRole::class => [
            'type' => Form\AdminRole::class,
            'hydrator' => 'ClassMethods',
            'input_filter' => InputFilter\AdminRole::class,
        ],
        Form\Authenticate::class => [
            'type' => Form\Authenticate::class,
            'hydrator' => 'ClassMethods',
            'input_filter' => AuthenticateInputFilter::class,
        ],
        Form\ChangeIdentity::class => [
            'type' => Form\ChangeIdentity::class,
            'hydrator' => 'ClassMethods',
            'input_filter' => ChangeIdentityInputFilter::class,
        ],
        Form\CreateApplication::class => [
            'type' => Form\CreateApplication::class,
            'hydrator' => [
                'type' => 'ClassMethods',
                'options' => [
                    'underscoreSeparatedKeys' => false,
                ],
            ],
            'input_filter' => CreateApplicationInputFilter::class,
        ],
        Form\Profile::class => [
            'type' => Form\Profile::class,
            'hydrator' => 'ClassMethods',
            'input_filter' => ProfileInputFilter::class,
        ],
        Form\RequestPassword::class => [
            'type' => Form\RequestPassword::class,
            'hydrator' => 'ClassMethods',
            'input_filter' => RequestPasswordInputFilter::class,
        ],
        Form\ResetPassword::class => [
            'type' => Form\ResetPassword::class,
            'hydrator' => 'ClassMethods',
            'input_filter' => ResetPasswordInputFilter::class,
        ],
        Form\VerifyCode::class => [
            'type' => Form\VerifyCode::class,
            'hydrator' => 'ClassMethods',
            'input_filter' => VerifyCodeInputFilter::class,
        ],
        Form\VerifyEmail::class => [
            'type' => Form\VerifyEmail::class,
            'hydrator' => 'ClassMethods',
            'input_filter' => VerifyEmailInputFilter::class,
        ],
    ],
    'input_filters' => [
        'factories' => [
            AuthenticateInputFilter::class => AuthenticateInputFilterFactory::class,
        ],
        'invokables' => [
            InputFilter\AdminInvite::class => InputFilter\AdminInvite::class,
            AccountInputFilter::class => AccountInputFilter::class,
            AddEmailInputFilter::class => AddEmailInputFilter::class,
            ChangeIdentityInputFilter::class => ChangeIdentityInputFilter::class,
            CreateApplicationInputFilter::class => CreateApplicationInputFilter::class,
            ProfileInputFilter::class => ProfileInputFilter::class,
            RequestPasswordInputFilter::class => RequestPasswordInputFilter::class,
            ResetPasswordInputFilter::class => ResetPasswordInputFilter::class,
            InputFilter\Role::class => InputFilter\Role::class,
            VerifyCodeInputFilter::class => VerifyCodeInputFilter::class,
            VerifyEmailInputFilter::class => VerifyEmailInputFilter::class,
        ],
    ],
    'router' => [
        'routes' => [
            'admin' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/administration',
                ],
                'child_routes' => [
                    'usermanagement' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => '/usermanagement',
                        ],
                        'child_routes' => [
                            'accounts' => [
                                'type' => 'Literal',
                                'options' => [
                                    'route' => '/accounts',
                                    'defaults' => [
                                        'controller' => AdminAccountsController::class,
                                        'action' => 'index',
                                    ],
                                ],
                                'may_terminate' => true,
                                'child_routes' => [
                                    'invite' => [
                                        'type' => 'Literal',
                                        'options' => [
                                            'route' => '/invite',
                                            'defaults' => [
                                                'action' => 'invite',
                                            ],
                                        ],
                                    ],
                                    'update' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/update/:id',
                                            'defaults' => [
                                                'action' => 'update',
                                            ],
                                        ],
                                    ],
                                    'delete' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/delete/:id',
                                            'defaults' => [
                                                'action' => 'delete',
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                            'directories' => [
                                'type' => 'Literal',
                                'options' => [
                                    'route' => '/directories',
                                    'defaults' => [
                                        'controller' => Mvc\Controller\AdminDirectories::class,
                                        'action' => 'index',
                                    ],
                                ],
                                'may_terminate' => true,
                                'child_routes' => [
                                    'disable' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/disable/:type',
                                            'defaults' => [
                                                'controller' => Mvc\Controller\AdminDirectories::class,
                                                'action' => 'disable',
                                            ],
                                        ],
                                    ],
                                    'enable' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/enable/:type',
                                            'defaults' => [
                                                'controller' => Mvc\Controller\AdminDirectories::class,
                                                'action' => 'enable',
                                            ],
                                        ],
                                    ],
                                    'ldap' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/update/ldap',
                                            'defaults' => [
                                                'controller' => Mvc\Controller\AdminDirectoriesLdap::class,
                                                'action' => 'update',
                                            ],
                                        ],
                                    ],
                                    'move-down' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/move-down/:type',
                                            'defaults' => [
                                                'controller' => Mvc\Controller\AdminDirectories::class,
                                                'action' => 'move-down',
                                            ],
                                        ],
                                    ],
                                    'move-up' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/move-up/:type',
                                            'defaults' => [
                                                'controller' => Mvc\Controller\AdminDirectories::class,
                                                'action' => 'move-up',
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                            'groups' => [
                                'type' => 'Literal',
                                'options' => [
                                    'route' => '/groups',
                                    'defaults' => [
                                        'controller' => AdminGroupsController::class,
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
                                                'action' => 'create',
                                            ],
                                        ],
                                    ],
                                    'update' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/update/:id',
                                            'defaults' => [
                                                'action' => 'update',
                                            ],
                                        ],
                                    ],
                                    'delete' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/delete/:id',
                                            'defaults' => [
                                                'action' => 'delete',
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                            'roles' => [
                                'type' => 'Literal',
                                'options' => [
                                    'route' => '/roles',
                                    'defaults' => [
                                        'controller' => AdminRolesController::class,
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
                                                'action' => 'create',
                                            ],
                                        ],
                                    ],
                                    'update' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/update/:id',
                                            'defaults' => [
                                                'action' => 'update',
                                            ],
                                        ],
                                    ],
                                    'delete' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/delete/:id',
                                            'defaults' => [
                                                'action' => 'delete',
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
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
                    'resource' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => '/resource',
                            'defaults' => [
                                'action' => 'resource',
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
                                'code' => '[a-zA-Z0-9]{32}',
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
                        'may_terminate' => true,
                        'child_routes' => [
                            'change-credential' => [
                                'type' => 'Literal',
                                'options' => [
                                    'route' => '/change/credential',
                                    'defaults' => [
                                        'controller' => Account::class,
                                        'action' => 'changeCredential',
                                    ],
                                ],
                            ],
                            'change-identity' => [
                                'type' => 'Literal',
                                'options' => [
                                    'route' => '/change/identity',
                                    'defaults' => [
                                        'controller' => Account::class,
                                        'action' => 'changeIdentity',
                                    ],
                                ],
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
                        'may_terminate' => true,
                        'child_routes' => [
                            'add' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/add',
                                    'defaults' => [
                                        'controller' => Email::class,
                                        'action' => 'add',
                                    ],
                                ],
                            ],
                            'primary' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/primary/:id',
                                    'defaults' => [
                                        'controller' => Email::class,
                                        'action' => 'primary',
                                    ],
                                ],
                            ],
                            'verify' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/verify/:id[/:code]',
                                    'defaults' => [
                                        'controller' => Email::class,
                                        'action' => 'verify',
                                    ],
                                    'constraints' => [
                                        'code' => '[a-zA-Z0-9]{32}',
                                    ],
                                ],
                            ],
                            'delete' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/delete/:id',
                                    'defaults' => [
                                        'controller' => Email::class,
                                        'action' => 'delete',
                                    ],
                                ],
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
            TaskService\Account::class => TaskService\Service\AccountFactory::class,
            TaskService\Directory::class => TaskService\Service\DirectoryFactory::class,
            AuthenticationService::class => AuthenticationServiceFactory::class,
            ApplicationService::class => ApplicationServiceFactory::class,
            EmailTaskService::class => EmailTaskServiceFactory::class,
            TaskService\Group::class => TaskService\Service\GroupFactory::class,
            OAuthTaskService::class => OAuthTaskServiceFactory::class,
            PasswordChanger::class => PasswordChangerFactory::class,
            Roles::class => RolesFactory::class,
            Storage::class => StorageFactory::class,
            TwoFactorAuthenticationService::class => TwoFactorAuthenticationServiceFactory::class,
        ],
        'invokables' => [
            Authentication\Adapter\Service\PluginManager::class => Authentication\Adapter\Service\PluginManager::class,
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
            VerifyEmailCode::class => VerifyEmailCodeFactory::class,
        ],
    ],
    'view_helpers' => [
        'factories' => [
            'zourceAccount' => \ZourceUser\View\Helper\Service\AccountFactory::class,
        ],
    ],
    'view_manager' => [
        'template_map' => [
            'zource-user/account/index' => __DIR__ . '/../view/zource-user/account/index.phtml',
            'zource-user/admin-accounts/index' => __DIR__ . '/../view/zource-user/admin-accounts/index.phtml',
            'zource-user/admin-accounts/invite' => __DIR__ . '/../view/zource-user/admin-accounts/invite.phtml',
            'zource-user/admin-accounts/update' => __DIR__ . '/../view/zource-user/admin-accounts/update.phtml',
            'zource-user/admin-groups/index' => __DIR__ . '/../view/zource-user/admin-groups/index.phtml',
            'zource-user/admin-directories/create' => __DIR__ . '/../view/zource-user/admin-directories/create.phtml',
            'zource-user/admin-directories/index' => __DIR__ . '/../view/zource-user/admin-directories/index.phtml',
            'zource-user/admin-directories/update' => __DIR__ . '/../view/zource-user/admin-directories/update.phtml',
            'zource-user/admin-roles/create' => __DIR__ . '/../view/zource-user/admin-roles/create.phtml',
            'zource-user/admin-roles/index' => __DIR__ . '/../view/zource-user/admin-roles/index.phtml',
            'zource-user/admin-roles/update' => __DIR__ . '/../view/zource-user/admin-roles/update.phtml',
            'zource-user/application/index' => __DIR__ . '/../view/zource-user/application/index.phtml',
            'zource-user/authenticate/login' => __DIR__ . '/../view/zource-user/authenticate/login.phtml',
            'zource-user/authenticate/login-tfa' => __DIR__ . '/../view/zource-user/authenticate/login-tfa.phtml',
            'zource-user/developer-application/create' => __DIR__ . '/../view/zource-user/developer-application/create.phtml',
            'zource-user/developer-application/update' => __DIR__ . '/../view/zource-user/developer-application/update.phtml',
            'zource-user/email/add' => __DIR__ . '/../view/zource-user/email/add.phtml',
            'zource-user/email/index' => __DIR__ . '/../view/zource-user/email/index.phtml',
            'zource-user/email/verify' => __DIR__ . '/../view/zource-user/email/verify.phtml',
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
    'zource_auth_adapters' => [
        'factories' => [
            Authentication\Adapter\Zource::class => Authentication\Adapter\Service\ZourceFactory::class,
        ],
    ],
    'zource_auth_directories' => [
        'username' => [
            'label' => 'Username',
            'enabled' => true,
            'service_name' => Authentication\Adapter\Zource::class,
            'service_options' => [
                'directory' => 'username',
            ],
        ],
        'email' => [
            'label' => 'E-mail',
            'enabled' => true,
            'service_name' => Authentication\Adapter\Zource::class,
            'service_options' => [
                'directory' => 'email',
            ],
        ],
        'ldap' => [
            'label' => 'LDAP',
            'enabled' => false,
            'update_route_name' => 'admin/usermanagement/directories/ldap',
            'service_name' => Authentication\Adapter\Zource::class,
            'service_options' => [
            ],
        ],
    ],
    'zource_conditions' => [
        'factories' => [
            'NotificationsExist' => NotificationsExistFactory::class,
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
            'oauth/resource' => false,
            'oauth' => false,
            'request/password' => false,
            'request/reset-password' => false,
            'settings/*' => true,
        ],
        'routes' => [
        ],
    ],
    'zource_nav' => [
        'admin-navgroup' => [
            'items' => [
                'users' => [
                    'type' => 'label',
                    'priority' => 2000,
                    'options' => [
                        'label' => 'Users',
                        'route' => 'admin/usermanagement/accounts',
                    ],
                ],
            ],
        ],
        'admin-users' => [
            'items' => [
                'header-manage' => [
                    'type' => 'header',
                    'priority' => 1000,
                    'options' => [
                        'label' => 'Authentication',
                    ],
                ],
                'accounts' => [
                    'type' => 'label',
                    'priority' => 2000,
                    'options' => [
                        'label' => 'Accounts',
                        'route' => 'admin/usermanagement/accounts',
                    ],
                ],
                'directories' => [
                    'type' => 'label',
                    'priority' => 3000,
                    'options' => [
                        'label' => 'Directories',
                        'route' => 'admin/usermanagement/directories',
                    ],
                ],
                'header-authorization' => [
                    'type' => 'header',
                    'priority' => 4000,
                    'options' => [
                        'label' => 'Authorization',
                    ],
                ],
                'groups' => [
                    'type' => 'label',
                    'priority' => 5000,
                    'options' => [
                        'label' => 'Groups',
                        'route' => 'admin/usermanagement/groups',
                    ],
                ],
                'roles' => [
                    'type' => 'label',
                    'priority' => 6000,
                    'options' => [
                        'label' => 'Roles',
                        'route' => 'admin/usermanagement/roles',
                    ],
                ],
            ],
        ],
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
                'admin' => [
                    'child_items' => [
                        'users' => [
                            'type' => 'label',
                            'priority' => 300,
                            'options' => [
                                'label' => 'topBarAdministrationMenuUsers',
                                'route' => 'admin/usermanagement/accounts',
                            ],
                        ],
                    ],
                ],
                'profile' => [
                    'type' => 'dropdown',
                    'priority' => 5000,
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
                        'loggedInAsHeader' => [
                            'type' => 'header',
                            'priority' => 100,
                            'options' => [
                                'label' => 'topBarProfileMenuLoggedInAsHeader',
                            ],
                        ],
                        'loggedInAsText' => [
                            'type' => 'logged-in-as',
                            'priority' => 200,
                            'options' => [
                            ],
                        ],
                        'profileHeader' => [
                            'type' => 'header',
                            'priority' => 300,
                            'options' => [
                                'label' => 'topBarProfileMenuHeader',
                            ],
                        ],
                        'profile' => [
                            'type' => 'label',
                            'priority' => 400,
                            'options' => [
                                'label' => 'topBarProfileMenuProfile',
                                'route' => 'settings/profile',
                            ],
                        ],
                        'account' => [
                            'type' => 'label',
                            'priority' => 500,
                            'options' => [
                                'label' => 'topBarProfileMenuAccount',
                                'route' => 'settings/account',
                            ],
                        ],
                        'email' => [
                            'type' => 'label',
                            'priority' => 600,
                            'options' => [
                                'label' => 'topBarProfileMenuEmail',
                                'route' => 'settings/email',
                            ],
                        ],
                        'security' => [
                            'type' => 'label',
                            'priority' => 700,
                            'options' => [
                                'label' => 'topBarProfileMenuSecurity',
                                'route' => 'settings/security',
                            ],
                        ],
                        'applications' => [
                            'type' => 'label',
                            'priority' => 800,
                            'options' => [
                                'label' => 'topBarProfileMenuApplications',
                                'route' => 'settings/applications',
                            ],
                        ],
                        'separator' => [
                            'type' => 'separator',
                            'priority' => 900,
                        ],
                        'logout' => [
                            'type' => 'label',
                            'priority' => 1000,
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
                    'conditions' => [
                        'user-has-identity' => [
                            'type' => 'NotificationsExist',
                        ],
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
    'zource_notifications' => [],
    'zource_oauth' => [
        'server_options' => [
            'access_lifetime' => 3600,
            'allow_implicit' => true,
            'enforce_state' => true,
        ],
    ],
    'zource_ui_nav_items' => [
        'aliases' => [
            'logged-in-as' => LoggedInAs::class,
        ],
        'factories' => [
            LoggedInAs::class => LoggedInAsFactory::class,
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
