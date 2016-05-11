<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication;

use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use Zend\Cache\Service\StorageCacheAbstractServiceFactory;
use Zend\Db\Adapter\AdapterAbstractServiceFactory;
use Zend\Form\FormAbstractServiceFactory;
use Zend\InputFilter\InputFilterAbstractServiceFactory;
use Zend\Log\LoggerAbstractServiceFactory;
use Zend\Session\Config\ConfigInterface;
use Zend\Session\ManagerInterface;
use Zend\Session\SaveHandler\SaveHandlerInterface;
use Zend\Session\Service\SessionConfigFactory;
use Zend\Session\Service\SessionManagerFactory;
use Zend\Session\Storage\StorageInterface;
use Zend\Session\Validator\HttpUserAgent;
use Zend\Session\Validator\RemoteAddr;
use ZF\Apigility\Admin\Module as ApigilityModule;
use ZourceApplication\Authorization\Condition\ClassExists;
use ZourceApplication\Authorization\Condition\Service\PluginManager as AuthorizationConditionPluginManager;
use ZourceApplication\Mvc\Controller\Index;
use ZourceApplication\Session\Service\SaveHandlerFactory;
use ZourceApplication\Session\Service\SessionStorageFactory;
use ZourceApplication\Session\Service\StorageFactory;
use ZourceApplication\TaskService\RemoteAddressLookup;
use ZourceApplication\TaskService\Service\RemoteAddressLookupFactory;
use ZourceApplication\UI\Navigation\Item\DashboardList;
use ZourceApplication\UI\Navigation\Item\Dropdown;
use ZourceApplication\UI\Navigation\Item\Header;
use ZourceApplication\UI\Navigation\Item\Label;
use ZourceApplication\UI\Navigation\Item\Separator;
use ZourceApplication\UI\Navigation\Item\Service\ItemAbstractFactory;
use ZourceApplication\UI\Navigation\Item\Service\PluginManager as UiNavigationItemPluginManager;
use ZourceApplication\Validator\Service\UuidFactory;
use ZourceApplication\Validator\Uuid;
use ZourceApplication\View\Helper\FormDescription;
use ZourceApplication\View\Helper\UI\Service\NavFactory;

return [
    'controllers' => [
        'invokables' => [
            Index::class => Index::class,
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
    ],
    'input_filters' => array(
        'abstract_factories' => array(
            InputFilterAbstractServiceFactory::class,
        ),
    ),
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
                        'controller' => Index::class,
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'abstract_factories' => [
            StorageCacheAbstractServiceFactory::class,
            AdapterAbstractServiceFactory::class,
            FormAbstractServiceFactory::class,
            LoggerAbstractServiceFactory::class,
        ],
        'factories' => [
            ConfigInterface::class => SessionConfigFactory::class,
            ManagerInterface::class => SessionManagerFactory::class,
            StorageInterface::class => StorageFactory::class,
            SaveHandlerInterface::class => SaveHandlerFactory::class,
            RemoteAddressLookup::class => RemoteAddressLookupFactory::class,
        ],
        'invokables' => [
            'UnderscoreNamingStrategy' => UnderscoreNamingStrategy::class,
            AuthorizationConditionPluginManager::class => AuthorizationConditionPluginManager::class,
            UiNavigationItemPluginManager::class => UiNavigationItemPluginManager::class,
        ],
    ],
    'session_config' => [
        'name' => 'zource',
        'remember_me_seconds' => 3600,
        'gc_maxlifetime' => 3600,
    ],
    'session_manager' => [
        'storage' => 'Zend\Session\Storage\SessionArrayStorage2',
        'validators' => [
            RemoteAddr::class,
            HttpUserAgent::class,
        ],
        'options' => [
            'attach_default_validators' => true,
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
            Uuid::class => UuidFactory::class,
        ],
    ],
    'view_helpers' => [
        'factories' => [
            'zourceUiNav' => NavFactory::class,
        ],
        'invokables' => [
            'zourceFormDescription' => FormDescription::class,
        ],
    ],
    'view_manager' => [
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/500',
        'template_map' => [
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/500' => __DIR__ . '/../view/error/500.phtml',
            'layout/dialog' => __DIR__ . '/../view/layout/dialog.phtml',
            'layout/page-header' => __DIR__ . '/../view/layout/page-header.phtml',
            'zource-application/index/index' => __DIR__ . '/../view/zource-application/index/index.phtml',
        ],
    ],
    'zource_conditions' => [
        'invokables' => [
            'ClassExists' => ClassExists::class,
        ],
    ],
    'zource_guard' => [
        'identity' => [
            'dashboard' => true,
        ],
    ],
    'zource_nav' => [
        'top-bar-primary' => [
            'items' => [
                'dashboards' => [
                    'type' => 'dropdown',
                    'priority' => 1000,
                    'options' => [
                        'label' => 'layoutTopMenuDashboards',
                        'route' => 'dashboard',
                        'title' => 'Enter the Apigility development environment.',
                    ],
                    'conditions' => [
                        'class-exists' => [
                            'type' => 'ClassExists',
                            'options' => [
                                'fqcn' => 'ZF\\Apigility\\Admin\\Module',
                            ],
                        ],
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
                                'label' => 'layoutTopMenuDashboardsAvailable',
                            ],
                        ],
                        'dashboard-list' => [
                            'type' => 'dashboard-list',
                            'priority' => 200,
                            'options' => [
                            ],
                        ],
                        'separator' => [
                            'type' => 'separator',
                            'priority' => 300,
                        ],
                        'manage' => [
                            'type' => 'label',
                            'priority' => 400,
                            'options' => [
                                'label' => 'layoutTopMenuDashboardsManage',
                                'route' => 'dashboard',
                            ],
                        ],
                    ],
                ],
            ],
        ],
        'top-bar-secondary' => [
            'items' => [
                'apigility' => [
                    'type' => 'label',
                    'priority' => 10000,
                    'options' => [
                        'label' => 'Apigility',
                        'route' => 'zf-apigility/ui',
                        'title' => 'Enter the Apigility development environment.',
                    ],
                    'conditions' => [
                        'class-exists' => [
                            'type' => 'ClassExists',
                            'options' => [
                                'fqcn' => ApigilityModule::class,
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'zource_ui_nav_items' => [
        'abstract_factories' => [
            ItemAbstractFactory::class,
        ],
        'aliases' => [
            'dashboard-list' => DashboardList::class,
            'dropdown' => Dropdown::class,
            'label' => Label::class,
            'header' => Header::class,
            'separator' => Separator::class,
        ],
    ],
];
