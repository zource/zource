<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use Zend\Cache\Service\StorageCacheAbstractServiceFactory;
use Zend\Db\Adapter\AdapterAbstractServiceFactory;
use Zend\Form\FormAbstractServiceFactory;
use Zend\InputFilter\InputFilterAbstractServiceFactory;
use Zend\Log\LoggerAbstractServiceFactory;
use Zend\ServiceManager\Proxy\LazyServiceFactory;
use Zend\ServiceManager\Proxy\LazyServiceFactoryFactory;
use Zend\Session\Config\ConfigInterface;
use Zend\Session\ManagerInterface;
use Zend\Session\SaveHandler\SaveHandlerInterface;
use Zend\Session\Service\ContainerAbstractServiceFactory;
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
use ZourceApplication\TaskService\Service\SessionFactory;
use ZourceApplication\TaskService\Session;
use ZourceApplication\UI\Navigation\Item\DashboardList;
use ZourceApplication\UI\Navigation\Item\Dropdown;
use ZourceApplication\UI\Navigation\Item\Header;
use ZourceApplication\UI\Navigation\Item\Label;
use ZourceApplication\UI\Navigation\Item\Separator;
use ZourceApplication\UI\Navigation\Item\Service\ItemAbstractFactory;
use ZourceApplication\UI\Navigation\Item\Service\PluginManager as UiNavigationItemPluginManager;
use ZourceApplication\Validator\Service\UuidFactory;
use ZourceApplication\Validator\Uuid;
use ZourceApplication\View\Helper\FormAvatar;
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
    'lazy_services' => [
        'class_map' => [
            'doctrine.entitymanager.orm_default' => EntityManager::class,
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
                        'controller' => Index::class,
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'abstract_factories' => [
            AdapterAbstractServiceFactory::class,
            ContainerAbstractServiceFactory::class,
            FormAbstractServiceFactory::class,
            LoggerAbstractServiceFactory::class,
            StorageCacheAbstractServiceFactory::class,
        ],
        'delegators' => [
            'doctrine.entitymanager.orm_default' => [
                'LazyServiceFactory',
            ],
        ],
        'factories' => [
            Builder::class => BuilderFactory::class,
            ConfigInterface::class => SessionConfigFactory::class,
            'LazyServiceFactory' => LazyServiceFactoryFactory::class,
            ManagerInterface::class => SessionManagerFactory::class,
            RemoteAddressLookup::class => RemoteAddressLookupFactory::class,
            Session::class => SessionFactory::class,
            StorageInterface::class => StorageFactory::class,
            SaveHandlerInterface::class => SaveHandlerFactory::class,
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
            'zourceFormAvatar' => FormAvatar::class,
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
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'layout/page-header' => __DIR__ . '/../view/layout/page-header.phtml',
            'zource-application/index/index' => __DIR__ . '/../view/zource-application/index/index.phtml',
        ],
    ],
    'zource_conditions' => [
        'invokables' => [
            'ClassExists' => ClassExists::class,
        ],
    ],
    'zource_field_types' => [
        'avatar' => [
            'id' => 'avatar',
            'name' => 'Avatar',
            'description' => 'The representation of an avatar.',
            'form_element' => 'Zend\\Form\\Element\\Text',
            'view_helper' => 'zourceFormAvatar',
        ],
        'date' => [
            'id' => 'date',
            'name' => 'Date',
            'description' => 'The representation of a date.',
            'form_element' => 'Zend\\Form\\Element\\Date',
            'view_helper' => 'formDate',
        ],
        'datetime' => [
            'id' => 'datetime',
            'name' => 'Datetime',
            'description' => 'The representation of a date and a time.',
            'form_element' => 'Zend\\Form\\Element\\DateTime',
            'view_helper' => 'formDateTime',
        ],
        'color' => [
            'id' => 'color',
            'name' => 'Color',
            'description' => 'The representation of a color value.',
            'form_element' => 'Zend\\Form\\Element\\Color',
            'view_helper' => 'formText',
        ],
        'email_address' => [
            'id' => 'company',
            'name' => 'Company',
            'description' => 'The representation of a company.',
            'form_element' => 'Zend\\Form\\Element\\Text',
            'view_helper' => 'formText',
        ],
        'gender' => [
            'id' => 'gender',
            'name' => 'Gender',
            'description' => 'The representation of a gender.',
            'form_element' => 'Zend\\Form\\Element\\Radio',
            'form_element_options' => [
                'value_options' => [
                    // According to https://en.wikipedia.org/wiki/ISO/IEC_5218
                    0 => 'Not known',
                    1 => 'Male',
                    2 => 'Female',
                    9 => 'Not applicable',
                ],
            ],
            'view_helper' => 'formRadio',
        ],
        'longtext' => [
            'id' => 'text',
            'name' => 'Text',
            'description' => 'The representation of a textual value which can be up to 4.294.967.295 bytes.',
            'form_element' => 'Zend\\Form\\Element\\Textarea',
            'view_helper' => 'formTextarea',
        ],
        'mediumtext' => [
            'id' => 'text',
            'name' => 'Text',
            'description' => 'The representation of a textual value which can be up to 16,777,215 bytes.',
            'form_element' => 'Zend\\Form\\Element\\Textarea',
            'view_helper' => 'formTextarea',
        ],
        'numeric' => [
            'id' => 'numeric',
            'name' => 'Numeric',
            'description' => 'The representation of a numeric value.',
            'form_element' => 'Zend\\Form\\Element\\Text',
            'view_helper' => 'formText',
        ],
        'phone_number' => [
            'id' => 'company',
            'name' => 'Company',
            'description' => 'The representation of a company.',
            'form_element' => 'Zend\\Form\\Element\\Text',
            'view_helper' => 'formText',
        ],
        'text' => [
            'id' => 'text',
            'name' => 'Text',
            'description' => 'The representation of a textual value which can be up to 65.535 bytes.',
            'form_element' => 'Zend\\Form\\Element\\Textarea',
            'view_helper' => 'formTextarea',
        ],
        'tinytext' => [
            'id' => 'tinytext',
            'name' => 'TinyText',
            'description' => 'The representation of a textual value which can be up to 255 bytes.',
            'form_element' => 'Zend\\Form\\Element\\Text',
            'view_helper' => 'formText',
        ],
        'url' => [
            'id' => 'company',
            'name' => 'Company',
            'description' => 'The representation of a company.',
            'form_element' => 'Zend\\Form\\Element\\Text',
            'view_helper' => 'formUrl',
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
