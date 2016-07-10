<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceContact;

use Zend\Hydrator\ClassMethods;
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
use ZourceContact\Mvc\Controller\VCard as VCardController;
use ZourceContact\Mvc\Controller\Service\CompanyFactory as CompanyControllerFactory;
use ZourceContact\Mvc\Controller\Service\ContactFactory as ContactControllerFactory;
use ZourceContact\Mvc\Controller\Service\DirectoryFactory as DirectoryControllerFactory;
use ZourceContact\Mvc\Controller\Service\PersonFactory as PersonControllerFactory;
use ZourceContact\Mvc\Controller\Service\VCardFactory as VCardControllerFactory;
use ZourceContact\TaskService\Contact as ContactTaskService;
use ZourceContact\TaskService\Service\ContactFactory as ContactTaskServiceFactory;
use ZourceContact\ValueObject\ContactEntry;
use ZourceContact\View\Helper\CompanySelection;
use ZourceContact\View\Helper\ContactAvatar;
use ZourceContact\View\Helper\ContactDates;
use ZourceContact\View\Helper\Service\ContactFormFactory;

return [
    'controllers' => [
        'factories' => [
            CompanyController::class => CompanyControllerFactory::class,
            ContactController::class => ContactControllerFactory::class,
            DirectoryController::class => DirectoryControllerFactory::class,
            PersonController::class => PersonControllerFactory::class,
            VCardController::class => VCardControllerFactory::class,
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
        'fixture' => [
            __NAMESPACE__ => __DIR__ . '/../src/' . __NAMESPACE__ . '/Fixture',
        ],
    ],
    'hydrators' => [
        'invokables' => [
            'ZourceContactCompanyHydrator' => ClassMethods::class,
            'ZourceContactPersonHydrator' => ClassMethods::class,
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
                            'route' => '/view/:id',
                            'defaults' => [
                                'controller' => ContactController::class,
                                'action' => 'view',
                            ],
                        ],
                    ],
                    'vcard' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/vcard/:id',
                            'defaults' => [
                                'controller' => VCardController::class,
                                'action' => 'vcard',
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
            'zourceFormContactDates' => ContactDates::class,
        ],
        'factories' => [
            'zourceContactForm' => ContactFormFactory::class,
        ],
    ],
    'view_manager' => [
        'template_map' => [
            'zource-contact/company/create' => __DIR__ . '/../view/zource-contact/company/create.phtml',
            'zource-contact/company/update' => __DIR__ . '/../view/zource-contact/company/update.phtml',
            'zource-contact/company/view' => __DIR__ . '/../view/zource-contact/company/view.phtml',
            'zource-contact/directory/index' => __DIR__ . '/../view/zource-contact/directory/index.phtml',
            'zource-contact/person/create' => __DIR__ . '/../view/zource-contact/person/create.phtml',
            'zource-contact/person/update' => __DIR__ . '/../view/zource-contact/person/update.phtml',
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
            'avatar' => [
                'type' => 'avatar',
                'form_element_options' => [
                    'label' => 'Avatar',
                    'description' => 'The avatar of this company',
                ],
                'input_filter_options' => [
                    'required' => true,
                ],
            ],
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
                'type' => 'contact_dates',
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
            'notes' => [
                'type' => 'longtext',
                'form_element_options' => [
                    'label' => 'Notes',
                    'description' => 'Additional notes about this company.',
                ],
                'input_filter_options' => [
                    'required' => false,
                ],
            ],
        ],
        'person' => [
            'avatar' => [
                'type' => 'avatar',
                'form_element_options' => [
                    'label' => 'Avatar',
                    'description' => 'The avatar of this person.',
                ],
                'input_filter_options' => [
                    'required' => true,
                ],
            ],
            'gender' => [
                'type' => 'gender',
                'form_element_options' => [
                    'label' => 'Gender',
                    'description' => 'The gender of this person.',
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
                    'description' => 'The title for this person.',
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
                    'description' => 'The first name of this person.',
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
                    'description' => 'The phonetic first name of this person.',
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
                    'description' => 'The middle name of this person.',
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
                    'description' => 'The phonetic middle name of this person.',
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
                    'description' => 'The last name of this person.',
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
                    'description' => 'The phonetic last name of this person.',
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
                    'description' => 'The maiden name of this person.',
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
                    'description' => 'The suffix of this person.',
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
                    'description' => 'The nickname of this person.',
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
                    'description' => 'The job title of this person.',
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
                    'description' => 'The department that this person works at.',
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
                    'description' => 'The company that this person works at.',
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
                'type' => 'contact_dates',
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
            'notes' => [
                'type' => 'longtext',
                'form_element_options' => [
                    'label' => 'Notes',
                    'description' => 'Additional notes about this person.',
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
        'contact_dates' => [
            'id' => 'contact_dates',
            'name' => 'Contact Dates',
            'description' => 'The representation of dates for a contact.',
            'form_element' => 'ZourceContact\\Form\\Element\\ContactDates',
            'view_helper' => 'zourceFormContactDates',
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
                    'conditions' => [
                        'user-has-access' => [
                            'type' => 'UserHasAccess',
                            'options' => [
                                'resource' => 'contacts',
                                'permission' => 'manage',
                            ],
                        ],
                    ],
                ],
                'add-company' => [
                    'type' => 'label',
                    'priority' => 2000,
                    'options' => [
                        'label' => 'New company',
                        'route' => 'contacts/company/create',
                    ],
                    'conditions' => [
                        'user-has-access' => [
                            'type' => 'UserHasAccess',
                            'options' => [
                                'resource' => 'contacts',
                                'permission' => 'manage',
                            ],
                        ],
                    ],
                ],
                'add-person' => [
                    'type' => 'label',
                    'priority' => 3000,
                    'options' => [
                        'label' => 'New person',
                        'route' => 'contacts/person/create',
                    ],
                    'conditions' => [
                        'user-has-access' => [
                            'type' => 'UserHasAccess',
                            'options' => [
                                'resource' => 'contacts',
                                'permission' => 'manage',
                            ],
                        ],
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
                        'label' => 'Manage',
                    ],
                    'conditions' => [
                        'user-has-access' => [
                            'type' => 'UserHasAccess',
                            'options' => [
                                'resource' => 'contacts',
                                'permission' => 'manage',
                            ],
                        ],
                    ],
                ],
                'add-company' => [
                    'type' => 'label',
                    'priority' => 2000,
                    'options' => [
                        'label' => 'New company',
                        'route' => 'contacts/company/create',
                    ],
                    'conditions' => [
                        'user-has-access' => [
                            'type' => 'UserHasAccess',
                            'options' => [
                                'resource' => 'contacts',
                                'permission' => 'manage',
                            ],
                        ],
                    ],
                ],
                'add-person' => [
                    'type' => 'label',
                    'priority' => 3000,
                    'options' => [
                        'label' => 'New person',
                        'route' => 'contacts/person/create',
                    ],
                    'conditions' => [
                        'user-has-access' => [
                            'type' => 'UserHasAccess',
                            'options' => [
                                'resource' => 'contacts',
                                'permission' => 'manage',
                            ],
                        ],
                    ],
                ],
                'update-company' => [
                    'type' => 'label',
                    'priority' => 4000,
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
                        'user-has-access' => [
                            'type' => 'UserHasAccess',
                            'options' => [
                                'resource' => 'contacts',
                                'permission' => 'manage',
                            ],
                        ],
                    ],
                ],
                'update-person' => [
                    'type' => 'label',
                    'priority' => 4000,
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
                        'user-has-access' => [
                            'type' => 'UserHasAccess',
                            'options' => [
                                'resource' => 'contacts',
                                'permission' => 'manage',
                            ],
                        ],
                    ],
                ],
                'delete-company' => [
                    'type' => 'label',
                    'priority' => 5000,
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
                        'user-has-access' => [
                            'type' => 'UserHasAccess',
                            'options' => [
                                'resource' => 'contacts',
                                'permission' => 'manage',
                            ],
                        ],
                    ],
                ],
                'delete-person' => [
                    'type' => 'label',
                    'priority' => 5000,
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
                        'user-has-access' => [
                            'type' => 'UserHasAccess',
                            'options' => [
                                'resource' => 'contacts',
                                'permission' => 'manage',
                            ],
                        ],
                    ],
                ],
                'header-options' => [
                    'type' => 'header',
                    'priority' => 6000,
                    'options' => [
                        'label' => 'contactViewMenuContactOptions',
                    ],
                ],
                'details' => [
                    'type' => 'label',
                    'priority' => 7000,
                    'options' => [
                        'label' => 'contactViewMenuDetails',
                        'route' => 'contacts/view',
                        'route_reuse_matched_params' => true,
                    ],
                ],
                'vcard' => [
                    'type' => 'label',
                    'priority' => 8000,
                    'options' => [
                        'label' => 'contactViewMenuVCard',
                        'route' => 'contacts/vcard',
                        'route_reuse_matched_params' => true,
                    ],
                ],
            ],
        ],
    ],
    'zource_permissions' => [
        'contacts.manage' => 'Allows users to manage contacts.',
    ],
];
