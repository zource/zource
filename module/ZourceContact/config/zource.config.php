<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceContact;

use ZourceContact\Mvc\Controller\Directory;
use ZourceContact\Mvc\Controller\Service\DirectoryFactory;
use ZourceContact\TaskService\Contact as ContactTaskService;
use ZourceContact\TaskService\Service\ContactFactory as ContactTaskServiceFactory;
use ZourceContact\View\Helper\ContactAvatar;

return [
    'controllers' => [
        'factories' => [
            Directory::class => DirectoryFactory::class,
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
    'router' => [
        'routes' => [
            'contacts' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/contacts',
                    'defaults' => [
                        'controller' => Directory::class,
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'filter' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/filter/:name',
                            'defaults' => [
                                'controller' => Directory::class,
                                'action' => 'filter',
                            ],
                        ],
                    ],
                    'view' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/view/:type/:id',
                            'defaults' => [
                                'controller' => Directory::class,
                                'action' => 'view',
                            ],
                            'constraints' => [
                                'type' => 'company|person',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            ContactTaskService::class => ContactTaskServiceFactory::class,
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
    'zource_guard' => [
        'identity' => [
            'contacts' => true,
            'contacts/*' => true,
        ],
    ],
    'zource_nav' => [
        'contacts-directory' => [
            'items' => [
                'header-manage' => [
                    'type' => 'header',
                    'priority' => 1000,
                    'options' => [
                        'label' => 'Manage',
                    ],
                ],
                'add-company' => [
                    'type' => 'label',
                    'priority' => 2000,
                    'options' => [
                        'label' => 'New company',
                        'route' => 'contacts',
                    ],
                ],
                'add-person' => [
                    'type' => 'label',
                    'priority' => 3000,
                    'options' => [
                        'label' => 'New Person',
                        'route' => 'contacts',
                    ],
                ],
                'header-filter' => [
                    'type' => 'header',
                    'priority' => 4000,
                    'options' => [
                        'label' => 'Filters',
                    ],
                ],
                'separator' => [
                    'type' => 'separator',
                    'priority' => 5000,
                ],
                'all-contacts' => [
                    'type' => 'label',
                    'priority' => 6000,
                    'options' => [
                        'label' => 'contactsMenuAllContacts',
                        'route' => 'contacts',
                    ],
                ],
                'company-contacts' => [
                    'type' => 'label',
                    'priority' => 7000,
                    'options' => [
                        'label' => 'contactsMenuCompanies',
                        'route' => 'contacts/filter',
                        'route_params' => [
                            'name' => 'companies',
                        ],
                    ],
                ],
                'company-people' => [
                    'type' => 'label',
                    'priority' => 8000,
                    'options' => [
                        'label' => 'contactsMenuPeople',
                        'route' => 'contacts/filter',
                        'route_params' => [
                            'name' => 'people',
                        ],
                    ],
                ],
            ],
        ],
        'top-bar-primary' => [
            'items' => [
                'contact' => [
                    'type' => 'dropdown',
                    'priority' => 3000,
                    'options' => [
                        'label' => 'layoutTopMenuContact',
                        'route' => 'contacts',
                    ],
                    'conditions' => [
                        'user-has-identity' => [
                            'type' => 'UserHasIdentity',
                            'options' => [],
                        ],
                    ],
                ],
            ],
        ],
        'view-contact' => [
            'items' => [

            ],
        ],
    ],
    'view_helpers' => [
        'invokables' => [
            'zourceContactAvatar' => ContactAvatar::class,
        ],
    ],
    'view_manager' => [
        'template_map' => [
            'zource-contact/directory/filter' => __DIR__ . '/../view/zource-contact/directory/filter.phtml',
            'zource-contact/directory/index' => __DIR__ . '/../view/zource-contact/directory/index.phtml',
            'zource-contact/directory/view-company' => __DIR__ . '/../view/zource-contact/directory/view-company.phtml',
            'zource-contact/directory/view-person' => __DIR__ . '/../view/zource-contact/directory/view-person.phtml',
        ],
    ],
];
