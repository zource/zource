<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceContact;

use ZourceContact\Authorization\Condition\Service\ContactIsCurrentAccountFactory;
use ZourceContact\Authorization\Condition\Service\ContactTypeFactory;
use ZourceContact\Form\Service\CompanyFactory as CompanyFormFactory;
use ZourceContact\Form\Service\PersonFactory as PersonFormFactory;
use ZourceContact\InputFilter\Service\CompanyFactory as CompanyFactoryInputFilter;
use ZourceContact\InputFilter\Service\PersonFactory as PersonFactoryInputFilter;
use ZourceContact\Mvc\Controller\Company as CompanyController;
use ZourceContact\Mvc\Controller\Contact as ContactController;
use ZourceContact\Mvc\Controller\Directory as DirectoryController;
use ZourceContact\Mvc\Controller\Person as PersonController;
use ZourceContact\Mvc\Controller\Service\CompanyFactory as CompanyControllerFactory;
use ZourceContact\Mvc\Controller\Service\ContactFactory as ContactControllerFactory;
use ZourceContact\Mvc\Controller\Service\DirectoryFactory as DirectoryControllerFactory;
use ZourceContact\Mvc\Controller\Service\PersonFactory as PersonControllerFactory;
use ZourceContact\TaskService\Contact as ContactTaskService;
use ZourceContact\TaskService\Service\ContactFactory as ContactTaskServiceFactory;
use ZourceContact\ValueObject\ContactEntry;
use ZourceContact\View\Helper\CompanySelection;
use ZourceContact\View\Helper\ContactAvatar;
use ZourceContact\View\Helper\Service\ContactFormFactory;

return [
    'controllers' => [
        'factories' => [
            CompanyController::class => CompanyControllerFactory::class,
            ContactController::class => ContactControllerFactory::class,
            DirectoryController::class => DirectoryControllerFactory::class,
            PersonController::class => PersonControllerFactory::class,
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
    'input_filters' => [
        'factories' => [
            'ZourceContactCompanyInputFilter' => CompanyFactoryInputFilter::class,
            'ZourceContactPersonInputFilter' => PersonFactoryInputFilter::class,
        ],
    ],
    'router' => [
        'routes' => [
            'contacts' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/contacts',
                    'defaults' => [
                        'controller' => DirectoryController::class,
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'company' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => '/company',
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'create' => [
                                'type' => 'Literal',
                                'options' => [
                                    'route' => '/create',
                                    'defaults' => [
                                        'controller' => CompanyController::class,
                                        'action' => 'create',
                                    ],
                                ],
                            ],
                            'update' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/update/:id',
                                    'defaults' => [
                                        'controller' => CompanyController::class,
                                        'action' => 'update',
                                    ],
                                ],
                            ],
                            'delete' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/delete/:id',
                                    'defaults' => [
                                        'controller' => CompanyController::class,
                                        'action' => 'delete',
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'person' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => '/person',
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'create' => [
                                'type' => 'Literal',
                                'options' => [
                                    'route' => '/create',
                                    'defaults' => [
                                        'controller' => PersonController::class,
                                        'action' => 'create',
                                    ],
                                ],
                            ],
                            'update' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/update/:id',
                                    'defaults' => [
                                        'controller' => PersonController::class,
                                        'action' => 'update',
                                    ],
                                ],
                            ],
                            'delete' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/delete/:id',
                                    'defaults' => [
                                        'controller' => PersonController::class,
                                        'action' => 'delete',
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'view' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/view/:type/:id',
                            'defaults' => [
                                'controller' => ContactController::class,
                                'action' => 'view',
                            ],
                            'constraints' => [
                                'type' => 'company|person',
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'activitystream' => [
                                'type' => 'Literal',
                                'options' => [
                                    'route' => '/activity-stream',
                                    'defaults' => [
                                        'controller' => ContactController::class,
                                        'action' => 'activityStream',
                                    ],
                                ],
                            ],
                            'vcard' => [
                                'type' => 'Literal',
                                'options' => [
                                    'route' => '/vcard',
                                    'defaults' => [
                                        'controller' => ContactController::class,
                                        'action' => 'vcard',
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
            ContactTaskService::class => ContactTaskServiceFactory::class,
            'ZourceContactCompanyForm' => CompanyFormFactory::class,
            'ZourceContactPersonForm' => PersonFormFactory::class,
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
    'view_helpers' => [
        'invokables' => [
            'zourceContactAvatar' => ContactAvatar::class,
            'zourceFormCompanySelection' => CompanySelection::class,
        ],
        'factories' => [
            'zourceContactForm' => ContactFormFactory::class,
        ],
    ],
    'view_manager' => [
        'template_map' => [
            'zource-contact/company/create' => __DIR__ . '/../view/zource-contact/company/create.phtml',
            'zource-contact/company/view' => __DIR__ . '/../view/zource-contact/company/view.phtml',
            'zource-contact/directory/index' => __DIR__ . '/../view/zource-contact/directory/index.phtml',
            'zource-contact/person/create' => __DIR__ . '/../view/zource-contact/person/create.phtml',
            'zource-contact/person/view' => __DIR__ . '/../view/zource-contact/person/view.phtml',
        ],
    ],
    'zource_conditions' => [
        'factories' => [
            'ContactIsCurrentAccount' => ContactIsCurrentAccountFactory::class,
            'ContactType' => ContactTypeFactory::class,
        ],
    ],
    'zource_contact_fields' => [
        'company' => [
            'name' => [
                'type' => 'tinytext',
                'form_element_options' => [
                    'label' => 'Name',
                    'description' => 'The name of the company.',
                ],
                'input_filter_options' => [
                    'required' => true,
                ],
            ],
        ],
        'person' => [
            'avatar' => [
                'type' => 'avatar',
                'form_element_options' => [
                    'label' => 'Avatar',
                ],
                'input_filter_options' => [
                    'required' => false,
                ],
            ],
            'gender' => [
                'type' => 'gender',
                'form_element_options' => [
                    'label' => 'Gender',
                ],
                'input_filter_options' => [
                    'required' => true,
                ],
            ],
            'prefix' => [
                'type' => 'tinytext',
                'category' => 'names',
                'form_element_options' => [
                    'label' => 'Prefix',
                ],
                'input_filter_options' => [
                    'required' => false,
                ],
            ],
            'first_name' => [
                'type' => 'tinytext',
                'category' => 'names',
                'form_element_options' => [
                    'label' => 'First name',
                ],
                'input_filter_options' => [
                    'required' => true,
                ],
            ],
            'phonetic_first_name' => [
                'type' => 'tinytext',
                'category' => 'names',
                'form_element_options' => [
                    'label' => 'Phonetic first name',
                ],
                'input_filter_options' => [
                    'required' => false,
                ],
            ],
            'pronunciation_first_name' => [
                'type' => 'tinytext',
                'category' => 'names',
                'form_element_options' => [
                    'label' => 'Pronunciation first name',
                ],
                'input_filter_options' => [
                    'required' => false,
                ],
            ],
            'middle_name' => [
                'type' => 'tinytext',
                'category' => 'names',
                'form_element_options' => [
                    'label' => 'Middle name',
                ],
                'input_filter_options' => [
                    'required' => false,
                ],
            ],
            'phonetic_middle_name' => [
                'type' => 'tinytext',
                'category' => 'names',
                'form_element_options' => [
                    'label' => 'Phonetic middle name',
                ],
                'input_filter_options' => [
                    'required' => false,
                ],
            ],
            'last_name' => [
                'type' => 'tinytext',
                'category' => 'names',
                'form_element_options' => [
                    'label' => 'Last name',
                ],
                'input_filter_options' => [
                    'required' => true,
                ],
            ],
            'phonetic_last_name' => [
                'type' => 'tinytext',
                'category' => 'names',
                'form_element_options' => [
                    'label' => 'Phonetic last name',
                ],
                'input_filter_options' => [
                    'required' => false,
                ],
            ],
            'pronunciation_last_name' => [
                'type' => 'tinytext',
                'category' => 'names',
                'form_element_options' => [
                    'label' => 'Pronunciation last name',
                ],
                'input_filter_options' => [
                    'required' => false,
                ],
            ],
            'maiden_name' => [
                'type' => 'tinytext',
                'category' => 'names',
                'form_element_options' => [
                    'label' => 'Maiden name',
                ],
                'input_filter_options' => [
                    'required' => false,
                ],
            ],
            'suffix' => [
                'type' => 'tinytext',
                'category' => 'names',
                'form_element_options' => [
                    'label' => 'Suffix',
                ],
                'input_filter_options' => [
                    'required' => false,
                ],
            ],
            'nickname' => [
                'type' => 'tinytext',
                'category' => 'names',
                'form_element_options' => [
                    'label' => 'Nickname',
                ],
                'input_filter_options' => [
                    'required' => false,
                ],
            ],
            'job_title' => [
                'type' => 'tinytext',
                'category' => 'names',
                'form_element_options' => [
                    'label' => 'Job title',
                ],
                'input_filter_options' => [
                    'required' => false,
                ],
            ],
            'department' => [
                'type' => 'tinytext',
                'category' => 'names',
                'form_element_options' => [
                    'label' => 'Department',
                ],
                'input_filter_options' => [
                    'required' => false,
                ],
            ],
            'company' => [
                'type' => 'company',
                'category' => 'names',
                'form_element_options' => [
                    'label' => 'Company',
                ],
                'input_filter_options' => [
                    'required' => false,
                ],
            ],
            'phone_number' => [
                'type' => 'phone_number',
                'category' => 'phone_number',
                'options' => [
                    'custom_label_allowed' => true,
                    'types' => [
                        'home',
                        'work',
                        'mobile',
                        'main',
                        'home fax',
                        'work fax',
                        'pager',
                        'other',
                    ],
                ],
                'form_element_options' => [
                    'label' => 'Phone number',
                ],
                'input_filter_options' => [
                    'required' => false,
                ],

            ],
            'email_address' => [
                'type' => 'email_address',
                'category' => 'email_address',
                'options' => [
                    'custom_label_allowed' => true,
                    'types' => [
                        'home',
                        'work',
                        'other',
                    ],
                ],
                'form_element_options' => [
                    'label' => 'E-mail address',
                ],
                'input_filter_options' => [
                    'required' => false,
                ],
            ],
            'url' => [
                'type' => 'url',
                'category' => 'url',
                'options' => [
                    'custom_label_allowed' => true,
                    'types' => [
                        'homepage',
                        'home',
                        'work',
                        'other',
                    ],
                ],
                'form_element_options' => [
                    'label' => 'URL',
                ],
                'input_filter_options' => [
                    'required' => false,
                ],
            ],
            'dates' => [
                'type' => 'date',
                'category' => 'dates',
                'options' => [
                    'date_of_birth',
                    'date_of_death',
                ],
                'form_element_options' => [
                    'label' => 'Dates',
                ],
                'input_filter_options' => [
                    'required' => false,
                ],
            ],
            'note' => [
                'type' => 'longtext',
                'form_element_options' => [
                    'label' => 'Notes',
                ],
                'input_filter_options' => [
                    'required' => false,
                ],
            ],
        ],
    ],
    'zource_field_types' => [
        'company' => [
            'id' => 'company',
            'name' => 'Company',
            'description' => 'The representation of a company.',
            'form_element' => 'ZourceContact\\Form\\Element\\CompanySelection',
            'view_helper' => 'zourceFormCompanySelection',
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
                        'route' => 'contacts/company/create',
                    ],
                ],
                'add-person' => [
                    'type' => 'label',
                    'priority' => 3000,
                    'options' => [
                        'label' => 'New person',
                        'route' => 'contacts/person/create',
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
                        'route' => 'contacts',
                        'route_options' => [
                            'query' => [
                                'filter' => 'companies',
                            ],
                        ],
                    ],
                ],
                'company-people' => [
                    'type' => 'label',
                    'priority' => 8000,
                    'options' => [
                        'label' => 'contactsMenuPeople',
                        'route' => 'contacts',
                        'route_options' => [
                            'query' => [
                                'filter' => 'people',
                            ],
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
                'header-manage' => [
                    'type' => 'header',
                    'priority' => 1000,
                    'options' => [
                        'label' => 'contactViewMenuContactOptions',
                    ],
                ],
                'details' => [
                    'type' => 'label',
                    'priority' => 2000,
                    'options' => [
                        'label' => 'contactViewMenuDetails',
                        'route' => 'contacts/view',
                        'route_reuse_matched_params' => true,
                    ],
                ],
                'activity' => [
                    'type' => 'label',
                    'priority' => 3000,
                    'options' => [
                        'label' => 'contactViewMenuActivityStream',
                        'route' => 'contacts/view/activitystream',
                        'route_reuse_matched_params' => true,
                    ],
                ],
                'vcard' => [
                    'type' => 'label',
                    'priority' => 4000,
                    'options' => [
                        'label' => 'contactViewMenuVCard',
                        'route' => 'contacts/view/vcard',
                        'route_reuse_matched_params' => true,
                    ],
                ],
                'separator' => [
                    'type' => 'separator',
                    'priority' => 5000,
                ],
                'update-company' => [
                    'type' => 'label',
                    'priority' => 6000,
                    'options' => [
                        'label' => 'contactViewMenuUpdate',
                        'route' => 'contacts/company/update',
                        'route_reuse_matched_params' => true,
                    ],
                    'conditions' => [
                        'contact-type' => [
                            'type' => 'ContactType',
                            'options' => [
                                'type' => ContactEntry::TYPE_COMPANY,
                            ],
                        ],
                    ],
                ],
                'update-person' => [
                    'type' => 'label',
                    'priority' => 6000,
                    'options' => [
                        'label' => 'contactViewMenuUpdate',
                        'route' => 'contacts/person/update',
                        'route_reuse_matched_params' => true,
                    ],
                    'conditions' => [
                        'contact-type' => [
                            'type' => 'ContactType',
                            'options' => [
                                'type' => ContactEntry::TYPE_PERSON,
                            ],
                        ],
                    ],
                ],
                'delete-company' => [
                    'type' => 'label',
                    'priority' => 7000,
                    'options' => [
                        'label' => 'contactViewMenuDelete',
                        'route' => 'contacts/company/delete',
                        'route_reuse_matched_params' => true,
                    ],
                    'conditions' => [
                        'contact-type' => [
                            'type' => 'ContactType',
                            'options' => [
                                'type' => ContactEntry::TYPE_COMPANY,
                            ],
                        ],
                    ],
                ],
                'delete-person' => [
                    'type' => 'label',
                    'priority' => 7000,
                    'options' => [
                        'label' => 'contactViewMenuDelete',
                        'route' => 'contacts/person/delete',
                        'route_reuse_matched_params' => true,
                    ],
                    'conditions' => [
                        'contact-type' => [
                            'type' => 'ContactType',
                            'options' => [
                                'type' => ContactEntry::TYPE_PERSON,
                            ],
                        ],
                        'contact-delete' => [
                            'type' => 'ContactIsCurrentAccount',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
