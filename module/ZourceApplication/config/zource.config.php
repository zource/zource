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
use ZourceApplication\Form\ApplicationSettings as ApplicationSettingsForm;
use ZourceApplication\Form\InstallPlugin as InstallPluginForm;
use ZourceApplication\InputFilter\ApplicationSettings as ApplicationSettingsInputFilter;
use ZourceApplication\InputFilter\InstallPlugin as InstallPluginInputFilter;
use ZourceApplication\Mvc\Controller\AdminPlugins as AdminPluginsController;
use ZourceApplication\Mvc\Controller\AdminSettings as AdminSettingsController;
use ZourceApplication\Mvc\Controller\Dashboard;
use ZourceApplication\Session\Service\SaveHandlerFactory;
use ZourceApplication\Session\Service\SessionStorageFactory;
use ZourceApplication\Session\Service\StorageFactory;
use ZourceApplication\TaskService\PluginManager;
use ZourceApplication\TaskService\RemoteAddressLookup;
use ZourceApplication\TaskService\Service\PluginManagerFactory;
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
use ZourceApplication\View\Helper\HumanBytes;
use ZourceApplication\View\Helper\UI\Service\NavFactory;

return [
    'controllers' => [
        'factories' => [
            Mvc\Controller\AdminCache::class => Mvc\Controller\Service\AdminCacheFactory::class,
            Mvc\Controller\AdminPlugins::class => Mvc\Controller\Service\AdminPluginsFactory::class,
            Mvc\Controller\AdminSettings::class => Mvc\Controller\Service\AdminSettingsFactory::class,
            Mvc\Controller\Dashboard::class => Mvc\Controller\Service\DashboardFactory::class,
        ],
    ],
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ => [
                'class' => 'Doctrine\\ORM\\Mapping\\Driver\\XmlDriver',
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/doctrine',
                ],
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ => __NAMESPACE__
                ],
            ],
        ],
        'eventmanager' => [
            'orm_default' => [
                'subscribers' => [
                    'Gedmo\\Timestampable\\TimestampableListener',
                ],
            ],
        ],
    ],
    'forms' => [
        Form\ApplicationSettings::class => [
            'type' => Form\ApplicationSettings::class,
            'input_filter' => InputFilter\ApplicationSettings::class,
        ],
        Form\Dashboard::class => [
            'type' => Form\Dashboard::class,
            'input_filter' => InputFilter\Dashboard::class,
        ],
        Form\InstallPlugin::class => [
            'type' => Form\InstallPlugin::class,
            'input_filter' => InputFilter\InstallPlugin::class,
        ],
    ],
    'input_filters' => [
        'abstract_factories' => [
            InputFilterAbstractServiceFactory::class,
        ],
        'invokables' => [
            InputFilter\ApplicationSettings::class => InputFilter\ApplicationSettings::class,
            InputFilter\Dashboard::class => InputFilter\Dashboard::class,
            InputFilter\InstallPlugin::class => InputFilter\InstallPlugin::class,
        ],
    ],
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
            'admin' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/administration',
                ],
                'child_routes' => [
                    'system' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => '/system',
                        ],
                        'child_routes' => [
                            'cache' => [
                                'type' => 'Literal',
                                'options' => [
                                    'route' => '/cache',
                                    'defaults' => [
                                        'controller' => Mvc\Controller\AdminCache::class,
                                        'action' => 'index',
                                    ],
                                ],
                                'may_terminate' => true,
                                'child_routes' => [
                                    'clear' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/clear/:id',
                                            'defaults' => [
                                                'controller' => Mvc\Controller\AdminCache::class,
                                                'action' => 'clear',
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                            'plugins' => [
                                'type' => 'Literal',
                                'options' => [
                                    'route' => '/plugins',
                                    'defaults' => [
                                        'controller' => AdminPluginsController::class,
                                        'action' => 'index',
                                    ],
                                ],
                                'may_terminate' => true,
                                'child_routes' => [
                                    'activate' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/activate/:id',
                                            'defaults' => [
                                                'controller' => AdminPluginsController::class,
                                                'action' => 'activate',
                                            ],
                                        ],
                                    ],
                                    'deactivate' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/deactivate/:id',
                                            'defaults' => [
                                                'controller' => AdminPluginsController::class,
                                                'action' => 'deactivate',
                                            ],
                                        ],
                                    ],
                                    'uninstall' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/uninstall/:id',
                                            'defaults' => [
                                                'controller' => AdminPluginsController::class,
                                                'action' => 'uninstall',
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
                                        'controller' => AdminSettingsController::class,
                                        'action' => 'index',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'dashboard' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => Dashboard::class,
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'widget-dialog' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => 'dashboard/widget-dialog',
                            'defaults' => [
                                'action' => 'widget-dialog',
                            ],
                        ],
                    ],
                    'manage' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => 'dashboard/manage',
                            'defaults' => [
                                'action' => 'manage',
                            ],
                        ],
                    ],
                    'select' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => 'dashboard/select/:id',
                            'defaults' => [
                                'action' => 'select',
                            ],
                        ],
                    ],
                    'create' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => 'dashboard/create',
                            'defaults' => [
                                'action' => 'create',
                            ],
                        ],
                    ],
                    'update' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => 'dashboard/update/:id',
                            'defaults' => [
                                'action' => 'update',
                            ],
                        ],
                    ],
                    'delete' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => 'dashboard/delete/:id',
                            'defaults' => [
                                'action' => 'delete',
                            ],
                        ],
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
            TaskService\CacheManager::class => TaskService\Service\CacheManagerFactory::class,
            TaskService\Dashboard::class => TaskService\Service\DashboardFactory::class,
            ConfigInterface::class => SessionConfigFactory::class,
            'LazyServiceFactory' => LazyServiceFactoryFactory::class,
            ManagerInterface::class => SessionManagerFactory::class,
            PluginManager::class => PluginManagerFactory::class,
            RemoteAddressLookup::class => RemoteAddressLookupFactory::class,
            Session::class => SessionFactory::class,
            StorageInterface::class => StorageFactory::class,
            SaveHandlerInterface::class => SaveHandlerFactory::class,
            TaskService\SettingsManager::class => TaskService\Service\SettingsManagerFactory::class,
        ],
        'invokables' => [
            AuthorizationConditionPluginManager::class => AuthorizationConditionPluginManager::class,
            UiNavigationItemPluginManager::class => UiNavigationItemPluginManager::class,
            'UnderscoreNamingStrategy' => UnderscoreNamingStrategy::class,
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
            'zourceSettings' => View\Helper\Service\SettingsFactory::class,
        ],
        'invokables' => [
            'formRow' => View\Helper\Zui\FormRow::class,
            //'formText' => View\Helper\Zui\FormText::class,
            'zourceBytes' => View\Helper\Bytes::class,
            'zourceFormAvatar' => FormAvatar::class,
            'zourceFormDescription' => FormDescription::class,
            'zourceFormSelect2' => View\Helper\FormSelect2::class,
            'zourceWidgetContainer' => View\Helper\WidgetContainer::class,
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
            'layout/page-structure' => __DIR__ . '/../view/layout/page-structure.phtml',
            'partial/api-menu' => __DIR__ . '/../view/partial/api-menu.phtml',
            'partial/footer' => __DIR__ . '/../view/partial/footer.phtml',
            'partial/head' => __DIR__ . '/../view/partial/head.phtml',
            'partial/paginator' => __DIR__ . '/../view/partial/paginator.phtml',
            'partial/scripts' => __DIR__ . '/../view/partial/scripts.phtml',
            'partial/top-bar' => __DIR__ . '/../view/partial/top-bar.phtml',
            'zf-apigility-documentation/show' => __DIR__ . '/../view/zource-application/apigility/show.phtml',
            'zource-application/admin-cache/index' => __DIR__ . '/../view/zource-application/admin-cache/index.phtml',
            'zource-application/admin-plugins/index' => __DIR__ . '/../view/zource-application/admin-plugin/index.phtml',
            'zource-application/admin-settings/index' => __DIR__ . '/../view/zource-application/admin-settings/index.phtml',
            'zource-application/apigility/api' => __DIR__ . '/../view/zource-application/apigility/api.phtml',
            'zource-application/apigility/list' => __DIR__ . '/../view/zource-application/apigility/list.phtml',
            'zource-application/apigility/service' => __DIR__ . '/../view/zource-application/apigility/service.phtml',
            'zource-application/apigility/operation' => __DIR__ . '/../view/zource-application/apigility/operation.phtml',
            'zource-application/dashboard/index' => __DIR__ . '/../view/zource-application/dashboard/index.phtml',
            'zource-application/dashboard/manage' => __DIR__ . '/../view/zource-application/dashboard/manage.phtml',
            'zource-application/dashboard/create' => __DIR__ . '/../view/zource-application/dashboard/create.phtml',
            'zource-application/dashboard/update' => __DIR__ . '/../view/zource-application/dashboard/update.phtml',
        ],
    ],
    'zource_cache_manager' => [
        'items' => [
            'module-classmap' => [
                'type' => 'file',
                'label' => 'Module Classmap',
                'options' => [
                    'path' => 'data/cache/module-classmap-cache.application.module.cache.php',
                ],
            ],
            'module-config' => [
                'type' => 'file',
                'label' => 'Module Config',
                'options' => [
                    'path' => 'data/cache/module-config-cache.application.config.cache.php',
                ],
            ],
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
            'admin/*' => true,
            'dashboard' => true,
            'dashboard/*' => true,
            'zf-apigility/documentation' => true,
            'zf-apigility/*' => false,
        ],
    ],
    'zource_nav' => [
        'admin-navgroup' => [
            'items' => [
                'settings' => [
                    'type' => 'label',
                    'priority' => 1000,
                    'options' => [
                        'label' => 'System',
                        'route' => 'admin/system/settings',
                    ],
                ],
            ],
        ],
        'admin-system' => [
            'items' => [
                'header-manage' => [
                    'type' => 'header',
                    'priority' => 1000,
                    'options' => [
                        'label' => 'System',
                    ],
                ],
                'settings' => [
                    'type' => 'label',
                    'priority' => 2000,
                    'options' => [
                        'label' => 'Settings',
                        'route' => 'admin/system/settings',
                    ],
                ],
                'cache' => [
                    'type' => 'label',
                    'priority' => 3000,
                    'options' => [
                        'label' => 'Cache',
                        'route' => 'admin/system/cache',
                    ],
                ],
                'plugins' => [
                    'type' => 'label',
                    'priority' => 4000,
                    'options' => [
                        'label' => 'Plugins',
                        'route' => 'admin/system/plugins',
                    ],
                ],
            ],
        ],
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
                                'route' => 'dashboard/manage',
                            ],
                        ],
                    ],
                ],
            ],
        ],
        'top-bar-secondary' => [
            'items' => [
                'admin' => [
                    'type' => 'dropdown',
                    'priority' => 1000,
                    'options' => [
                        'label' => 'layoutTopMenuAdministration',
                        'route' => 'admin/system/settings',
                    ],
                    'conditions' => [
                        'user-has-identity' => [
                            'type' => 'UserHasAccess',
                            'options' => [
                                'resource' => 'application',
                                'permission' => 'manage',
                            ],
                        ],
                    ],
                    'child_items' => [
                        'administrationHeader' => [
                            'type' => 'header',
                            'priority' => 100,
                            'options' => [
                                'label' => 'topBarAdministrationMenuHeader',
                            ],
                        ],
                        'system' => [
                            'type' => 'label',
                            'priority' => 200,
                            'options' => [
                                'label' => 'topBarAdministrationMenuSystem',
                                'route' => 'admin/system/settings',
                            ],
                        ],
                    ],
                ],
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
    'zource_permissions' => [
        'application.manage' => 'Allows users to administer the application.',
    ],
    'zource_widgets' => [
        'html' => [
            'name' => 'HTML',
            'description' => 'A widget that can render raw HTML.',
        ],
        'open-weather' => [
            'name' => 'Open Weather',
            'description' => 'A widget that shows the weather conditions.',
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
        'factories' => [
            DashboardList::class => UI\Navigation\Item\Service\DashboardListFactory::class,
        ],
    ],
];
