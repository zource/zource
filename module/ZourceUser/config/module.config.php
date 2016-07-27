<?php
return array(
    'controllers' => array(
        'factories' => array(
            'ZourceUser\\V1\\Rpc\\GroupMembership\\Controller' => 'ZourceUser\\V1\\Rpc\\GroupMembership\\GroupMembershipControllerFactory',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'ZourceUser\\V1\\Rest\\Account\\AccountResource' => 'ZourceUser\\V1\\Rest\\Account\\AccountResourceFactory',
            'ZourceUser\\V1\\Rest\\Email\\EmailResource' => 'ZourceUser\\V1\\Rest\\Email\\EmailResourceFactory',
            'ZourceUser\\V1\\Rest\\Group\\GroupResource' => 'ZourceUser\\V1\\Rest\\Group\\GroupResourceFactory',
            'ZourceUser\\V1\\Rest\\Identity\\IdentityResource' => 'ZourceUser\\V1\\Rest\\Identity\\IdentityResourceFactory',
            'ZourceUser\\V1\\Rest\\Permission\\PermissionResource' => 'ZourceUser\\V1\\Rest\\Permission\\PermissionResourceFactory',
            'ZourceUser\\V1\\Rest\\Session\\SessionResource' => 'ZourceUser\\V1\\Rest\\Session\\SessionResourceFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'zource-user.rest.account' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/user-accounts[/:account_id]',
                    'defaults' => array(
                        'controller' => 'ZourceUser\\V1\\Rest\\Account\\Controller',
                    ),
                    'constraints' => array(
                        'account_id' => '[a-f0-9]{8}-?[a-f0-9]{4}-?4[a-f0-9]{3}-?[89ab][a-f0-9]{3}-?[a-f0-9]{12}',
                    ),
                ),
            ),
            'zource-user.rest.email' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/user-emails[/:email_id]',
                    'defaults' => array(
                        'controller' => 'ZourceUser\\V1\\Rest\\Email\\Controller',
                    ),
                    'constraints' => array(
                        'email_id' => '[a-f0-9]{8}-?[a-f0-9]{4}-?4[a-f0-9]{3}-?[89ab][a-f0-9]{3}-?[a-f0-9]{12}',
                    ),
                ),
            ),
            'zource-user.rest.group' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/user-groups[/:group_id]',
                    'defaults' => array(
                        'controller' => 'ZourceUser\\V1\\Rest\\Group\\Controller',
                    ),
                    'constraints' => array(
                        'group_id' => '[a-f0-9]{8}-?[a-f0-9]{4}-?4[a-f0-9]{3}-?[89ab][a-f0-9]{3}-?[a-f0-9]{12}',
                    ),
                ),
            ),
            'zource-user.rest.identity' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/user-identities[/:identity_id]',
                    'defaults' => array(
                        'controller' => 'ZourceUser\\V1\\Rest\\Identity\\Controller',
                    ),
                    'constraints' => array(
                        'identity_id' => '[a-f0-9]{8}-?[a-f0-9]{4}-?4[a-f0-9]{3}-?[89ab][a-f0-9]{3}-?[a-f0-9]{12}',
                    ),
                ),
            ),
            'zource-user.rest.permission' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/user-permissions[/:permission_id]',
                    'defaults' => array(
                        'controller' => 'ZourceUser\\V1\\Rest\\Permission\\Controller',
                    ),
                ),
            ),
            'zource-user.rest.session' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/user-sessions[/:session_id]',
                    'defaults' => array(
                        'controller' => 'ZourceUser\\V1\\Rest\\Session\\Controller',
                    ),
                    'constraints' => array(
                        //'session_id' => '^[a-zA-Z0-9]{32}$',
                    ),
                ),
            ),
            'zource-user.rpc.group-register' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/user-group/membership',
                    'defaults' => array(
                        'controller' => 'ZourceUser\\V1\\Rpc\\GroupMembership\\Controller',
                        'action' => 'groupMembership',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'zource-user.rest.account',
            1 => 'zource-user.rest.account-details',
            3 => 'zource-user.rest.email',
            4 => 'zource-user.rest.group',
            5 => 'zource-user.rest.identity',
            6 => 'zource-user.rest.permission',
            6 => 'zource-user.rest.session',
            7 => 'zource-user.rpc.group-register',
        ),
    ),
    'zf-rest' => array(
        'ZourceUser\\V1\\Rest\\Account\\Controller' => array(
            'listener' => 'ZourceUser\\V1\\Rest\\Account\\AccountResource',
            'route_name' => 'zource-user.rest.account',
            'route_identifier_name' => 'account_id',
            'collection_name' => 'account',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => 'page_size',
            'entity_class' => 'ZourceUser\\V1\\Rest\\Account\\AccountInterface',
            'collection_class' => 'ZourceUser\\V1\\Rest\\Account\\AccountCollection',
            'service_name' => 'Account',
        ),
        'ZourceUser\\V1\\Rest\\Email\\Controller' => array(
            'listener' => 'ZourceUser\\V1\\Rest\\Email\\EmailResource',
            'route_name' => 'zource-user.rest.email',
            'route_identifier_name' => 'email_id',
            'collection_name' => 'email',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'ZourceUser\\V1\\Rest\\Email\\EmailEntity',
            'collection_class' => 'ZourceUser\\V1\\Rest\\Email\\EmailCollection',
            'service_name' => 'Email',
        ),
        'ZourceUser\\V1\\Rest\\Identity\\Controller' => array(
            'listener' => 'ZourceUser\\V1\\Rest\\Identity\\IdentityResource',
            'route_name' => 'zource-user.rest.identity',
            'route_identifier_name' => 'identity_id',
            'collection_name' => 'identity',
            'entity_http_methods' => array(
                0 => 'DELETE',
                1 => 'GET',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'ZourceUser\\V1\\Rest\\Identity\\IdentityEntity',
            'collection_class' => 'ZourceUser\\V1\\Rest\\Identity\\IdentityCollection',
            'service_name' => 'Identity',
        ),
        'ZourceUser\\V1\\Rest\\Group\\Controller' => array(
            'listener' => 'ZourceUser\\V1\\Rest\\Group\\GroupResource',
            'route_name' => 'zource-user.rest.group',
            'route_identifier_name' => 'group_id',
            'collection_name' => 'group',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'ZourceUser\\V1\\Rest\\Group\\GroupEntity',
            'collection_class' => 'ZourceUser\\V1\\Rest\\Group\\GroupCollection',
            'service_name' => 'Group',
        ),
        'ZourceUser\\V1\\Rest\\Permission\\Controller' => array(
            'listener' => 'ZourceUser\\V1\\Rest\\Permission\\PermissionResource',
            'route_name' => 'zource-user.rest.permission',
            'route_identifier_name' => 'permission_id',
            'collection_name' => 'permission',
            'entity_http_methods' => array(
                0 => 'GET',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => 'page_size',
            'entity_class' => 'ZourceUser\\V1\\Rest\\Permission\\PermissionEntity',
            'collection_class' => 'ZourceUser\\V1\\Rest\\Permission\\PermissionCollection',
            'service_name' => 'Permission',
        ),
        'ZourceUser\\V1\\Rest\\Session\\Controller' => array(
            'listener' => 'ZourceUser\\V1\\Rest\\Session\\SessionResource',
            'route_name' => 'zource-user.rest.session',
            'route_identifier_name' => 'session_id',
            'collection_name' => 'session',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => 'page_size',
            'entity_class' => 'ZourceUser\\V1\\Rest\\Session\\SessionEntity',
            'collection_class' => 'ZourceUser\\V1\\Rest\\Session\\SessionCollection',
            'service_name' => 'Session',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'ZourceUser\\V1\\Rest\\Account\\Controller' => 'HalJson',
            'ZourceUser\\V1\\Rest\\Email\\Controller' => 'HalJson',
            'ZourceUser\\V1\\Rest\\Group\\Controller' => 'HalJson',
            'ZourceUser\\V1\\Rest\\Identity\\Controller' => 'HalJson',
            'ZourceUser\\V1\\Rest\\Permission\\Controller' => 'HalJson',
            'ZourceUser\\V1\\Rest\\Session\\Controller' => 'HalJson',
            'ZourceUser\\V1\\Rpc\\GroupMembership\\Controller' => 'Json',
        ),
        'accept_whitelist' => array(
            'ZourceUser\\V1\\Rest\\Account\\Controller' => array(
                0 => 'application/vnd.zource-user.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'ZourceUser\\V1\\Rest\\Email\\Controller' => array(
                0 => 'application/vnd.zource-user.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'ZourceUser\\V1\\Rest\\Group\\Controller' => array(
                0 => 'application/vnd.zource-user.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'ZourceUser\\V1\\Rest\\Identity\\Controller' => array(
                0 => 'application/vnd.zource-user.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'ZourceUser\\V1\\Rest\\Permission\\Controller' => array(
                0 => 'application/vnd.zource-user.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'ZourceUser\\V1\\Rest\\Session\\Controller' => array(
                0 => 'application/vnd.zource-user.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'ZourceUser\\V1\\Rpc\\GroupMembership\\Controller' => array(
                0 => 'application/vnd.zource-user.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
        ),
        'content_type_whitelist' => array(
            'ZourceUser\\V1\\Rest\\Account\\Controller' => array(
                0 => 'application/vnd.zource-user.v1+json',
                1 => 'application/json',
            ),
            'ZourceUser\\V1\\Rest\\Email\\Controller' => array(
                0 => 'application/vnd.zource-user.v1+json',
                1 => 'application/json',
            ),
            'ZourceUser\\V1\\Rest\\Group\\Controller' => array(
                0 => 'application/vnd.zource-user.v1+json',
                1 => 'application/json',
            ),
            'ZourceUser\\V1\\Rest\\Identity\\Controller' => array(
                0 => 'application/vnd.zource-user.v1+json',
                1 => 'application/json',
            ),
            'ZourceUser\\V1\\Rest\\Permission\\Controller' => array(
                0 => 'application/vnd.zource-user.v1+json',
                1 => 'application/json',
            ),
            'ZourceUser\\V1\\Rest\\Session\\Controller' => array(
                0 => 'application/vnd.zource-user.v1+json',
                1 => 'application/json',
            ),
            'ZourceUser\\V1\\Rpc\\GroupMembership\\Controller' => array(
                0 => 'application/vnd.zource-user.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'ZourceUser\\V1\\Rest\\Account\\AccountEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-user.rest.account',
                'route_identifier_name' => 'account_id',
                'hydrator' => 'Zend\\Hydrator\\ObjectProperty',
            ),
            'ZourceUser\\V1\\Rest\\Account\\AccountCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-user.rest.account',
                'route_identifier_name' => 'account_id',
                'is_collection' => true,
            ),
            'ZourceUser\\V1\\Rest\\Email\\EmailEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-user.rest.email',
                'route_identifier_name' => 'email_id',
                'hydrator' => 'Zend\\Hydrator\\ObjectProperty',
            ),
            'ZourceUser\\V1\\Rest\\Email\\EmailCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-user.rest.email',
                'route_identifier_name' => 'email_id',
                'is_collection' => true,
            ),
            'ZourceUser\\V1\\Rest\\Group\\GroupEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-user.rest.group',
                'route_identifier_name' => 'group_id',
                'hydrator' => 'Zend\\Hydrator\\ObjectProperty',
            ),
            'ZourceUser\\V1\\Rest\\Group\\GroupCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-user.rest.group',
                'route_identifier_name' => 'group_id',
                'is_collection' => true,
            ),
            'ZourceUser\\V1\\Rest\\Identity\\IdentityEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-user.rest.identity',
                'route_identifier_name' => 'identity_id',
                'hydrator' => 'Zend\\Hydrator\\ObjectProperty',
            ),
            'ZourceUser\\V1\\Rest\\Identity\\IdentityCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-user.rest.identity',
                'route_identifier_name' => 'identity_id',
                'is_collection' => true,
            ),
            'ZourceUser\\V1\\Rest\\Permission\\PermissionEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-user.rest.permission',
                'route_identifier_name' => 'permission_id',
                'hydrator' => 'Zend\\Hydrator\\ObjectProperty',
            ),
            'ZourceUser\\V1\\Rest\\Permission\\PermissionCollection' => array(
                'entity_identifier_name' => 'permission_id',
                'route_name' => 'zource-user.rest.permission',
                'route_identifier_name' => 'permission_id',
                'is_collection' => true,
            ),
            'ZourceUser\\V1\\Rest\\Session\\SessionEntity' => array(
                'entity_identifier_name' => 'sessionId',
                'route_name' => 'zource-user.rest.session',
                'route_identifier_name' => 'session_id',
                'hydrator' => 'Zend\\Hydrator\\ObjectProperty',
            ),
            'ZourceUser\\V1\\Rest\\Session\\SessionCollection' => array(
                'entity_identifier_name' => 'session_id',
                'route_name' => 'zource-user.rest.session',
                'route_identifier_name' => 'session_id',
                'is_collection' => true,
            ),
        ),
    ),
    'zf-mvc-auth' => array(
        'authorization' => array(
            'ZourceUser\\V1\\Rest\\Account\\Controller' => array(
                'collection' => array(
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
                'entity' => array(
                    'GET' => true,
                    'POST' => false,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ),
            ),
            'ZourceUser\\V1\\Rest\\Email\\Controller' => array(
                'collection' => array(
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
                'entity' => array(
                    'GET' => true,
                    'POST' => false,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ),
            ),
            'ZourceUser\\V1\\Rest\\Group\\Controller' => array(
                'collection' => array(
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
                'entity' => array(
                    'GET' => true,
                    'POST' => false,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ),
            ),
            'ZourceUser\\V1\\Rest\\Identity\\Controller' => array(
                'collection' => array(
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
                'entity' => array(
                    'GET' => true,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => true,
                ),
            ),
            'ZourceUser\\V1\\Rest\\Permission\\Controller' => array(
                'collection' => array(
                    'GET' => true,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
                'entity' => array(
                    'GET' => true,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => true,
                ),
            ),
            'ZourceUser\\V1\\Rest\\Session\\Controller' => array(
                'collection' => array(
                    'GET' => true,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
                'entity' => array(
                    'GET' => true,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => true,
                ),
            ),
            'ZourceUser\\V1\\Rpc\\GroupMembership\\Controller' => array(
                'actions' => array(
                    'GroupMembership' => array(
                        'GET' => false,
                        'POST' => true,
                        'PUT' => false,
                        'PATCH' => false,
                        'DELETE' => true,
                    ),
                ),
            ),
        ),
    ),
    'zf-content-validation' => array(
        'ZourceUser\\V1\\Rest\\Account\\Controller' => array(
            'input_filter' => 'ZourceUser\\V1\\Rest\\Account\\Validator',
        ),
        'ZourceUser\\V1\\Rest\\Email\\Controller' => array(
            'input_filter' => 'ZourceUser\\V1\\Rest\\Email\\Validator',
        ),
        'ZourceUser\\V1\\Rest\\Group\\Controller' => array(
            'input_filter' => 'ZourceUser\\V1\\Rest\\Group\\Validator',
        ),
        'ZourceUser\\V1\\Rest\\Identity\\Controller' => array(
            'input_filter' => 'ZourceUser\\V1\\Rest\\Identity\\Validator',
        ),
        'ZourceUser\\V1\\Rest\\Session\\Controller' => array(
            'input_filter' => 'ZourceUser\\V1\\Rest\\Session\\Validator',
        ),
        'ZourceUser\\V1\\Rpc\\GroupMembership\\Controller' => array(
            'input_filter' => 'ZourceUser\\V1\\Rpc\\GroupMembership\\Validator',
        ),
    ),
    'input_filter_specs' => array(
        'ZourceUser\\V1\\Rest\\Account\\Validator' => array(
            0 => array(
                'required' => false,
                'validators' => array(
                    0 => array(
                        'name' => 'ZourceApplication\\Validator\\Uuid',
                        'options' => array(),
                    ),
                ),
                'filters' => array(),
                'name' => 'id',
                'description' => 'The unique id of the user.',
            ),
            1 => array(
                'required' => true,
                'validators' => array(),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'name' => 'display_name',
                'description' => 'The display name of the user.',
            ),
        ),
        'ZourceUser\\V1\\Rest\\Email\\Validator' => array(
            0 => array(
                'required' => false,
                'validators' => array(
                    0 => array(
                        'name' => 'ZourceApplication\\Validator\\Uuid',
                        'options' => array(),
                    ),
                ),
                'filters' => array(),
                'name' => 'id',
                'description' => 'The unique id of the e-mail address.',
            ),
            1 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'ZourceApplication\\Validator\\Uuid',
                        'options' => array(),
                    ),
                ),
                'filters' => array(),
                'name' => 'account',
                'description' => 'The account to which the e-mail address belongs.',
            ),
            2 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\EmailAddress',
                        'options' => array(),
                    ),
                ),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'name' => 'address',
                'description' => 'The representation of the e-mail address.',
            ),
            3 => array(
                'required' => false,
                'validators' => array(),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'name' => 'primary',
                'description' => 'A flag that indicates whether or not the e-mail address is the primary address.',
            ),
            4 => array(
                'required' => false,
                'validators' => array(),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'name' => 'validated',
                'description' => 'A flag that indicates whether or not the e-mail address has been validated.',
            ),
        ),
        'ZourceUser\\V1\\Rest\\Group\\Validator' => array(
            0 => array(
                'required' => false,
                'validators' => array(
                    0 => array(
                        'name' => 'ZourceApplication\\Validator\\Uuid',
                        'options' => array(),
                    ),
                ),
                'filters' => array(),
                'name' => 'id',
                'description' => 'The unique id of the group.',
            ),
            1 => array(
                'required' => true,
                'validators' => array(),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'name' => 'name',
                'description' => 'The name of the group.',
            ),
        ),
        'ZourceUser\\V1\\Rest\\Identity\\Validator' => array(
            0 => array(
                'required' => false,
                'validators' => array(
                    0 => array(
                        'name' => 'ZourceApplication\\Validator\\Uuid',
                        'options' => array(),
                    ),
                ),
                'filters' => array(),
                'name' => 'id',
                'description' => 'The unique id of the identity.',
            ),
            1 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'ZourceApplication\\Validator\\Uuid',
                        'options' => array(),
                    ),
                ),
                'filters' => array(),
                'name' => 'account',
                'description' => 'The account to which the identity belongs.',
            ),
            2 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'ZourceUser\\Validator\\Directory',
                        'options' => array(
                            'valid_directories' => array(
                                0 => 'email',
                                1 => 'username',
                            ),
                        ),
                    ),
                ),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'name' => 'directory',
                'description' => 'The directory in which the identity resides.',
            ),
            3 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'ZourceUser\\Validator\\IdentityNotExists',
                        'options' => array(),
                    ),
                ),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'name' => 'identity',
                'description' => 'The representation of the identity.',
            ),
        ),
        'ZourceUser\\V1\\Rest\\Session\\Validator' => array(
            0 => array(
                'required' => false,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'max' => 32,
                            'min' => 32,
                        ),
                    ),
                ),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'name' => 'session_id',
                'description' => 'The id of the session.',
            ),
        ),
        'ZourceUser\\V1\\Rpc\\GroupMembership\\Validator' => array(
            0 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'ZourceApplication\\Validator\\Uuid',
                        'options' => array(),
                    ),
                ),
                'filters' => array(),
                'name' => 'account',
                'description' => 'The id of the account that joins the group.',
            ),
            1 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'ZourceApplication\\Validator\\Uuid',
                        'options' => array(),
                    ),
                ),
                'filters' => array(),
                'name' => 'group',
                'description' => 'The id of the group to join.',
            ),
        ),
        'test' => array(
            0 => array(
                'name' => 'test',
            ),
        ),
    ),
    'zf-rpc' => array(
        'ZourceUser\\V1\\Rpc\\GroupMembership\\Controller' => array(
            'service_name' => 'GroupMembership',
            'http_methods' => array(
                0 => 'POST',
                1 => 'DELETE',
            ),
            'route_name' => 'zource-user.rpc.group-register',
        ),
    ),
);
