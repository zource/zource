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
use Zend\Log\LoggerAbstractServiceFactory;
use ZourceApplication\Authorization\Condition\ClassExists;
use ZourceApplication\Authorization\Condition\Service\PluginManager as AuthorizationConditionPluginManager;
use ZourceApplication\Mvc\Controller\Index;
use ZourceApplication\UI\Navigation\Item\Dropdown;
use ZourceApplication\UI\Navigation\Item\Header;
use ZourceApplication\UI\Navigation\Item\Label;
use ZourceApplication\UI\Navigation\Item\Separator;
use ZourceApplication\UI\Navigation\Item\Service\ItemAbstractFactory;
use ZourceApplication\UI\Navigation\Item\Service\PluginManager as UiNavigationItemPluginManager;
use ZourceApplication\Validator\Service\UuidFactory;
use ZourceApplication\Validator\Uuid;
use ZourceApplication\View\Helper\UI\Service\NavFactory;

return [
    'controllers' => [
        'invokables' => [
            Index::class => Index::class,
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
            StorageCacheAbstractServiceFactory::class,
            AdapterAbstractServiceFactory::class,
            FormAbstractServiceFactory::class,
            LoggerAbstractServiceFactory::class,
        ],
        'invokables' => [
            'UnderscoreNamingStrategy' => UnderscoreNamingStrategy::class,
            AuthorizationConditionPluginManager::class => AuthorizationConditionPluginManager::class,
            UiNavigationItemPluginManager::class => UiNavigationItemPluginManager::class,
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
                                'fqcn' => 'ZF\\Apigility\\Admin\\Module',
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
            'dropdown' => Dropdown::class,
            'label' => Label::class,
            'header' => Header::class,
            'separator' => Separator::class,
        ],
    ],
];
