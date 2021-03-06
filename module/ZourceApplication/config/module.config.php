<?php
return array(
    'controllers' => array(
        'factories' => array(
            'ZourceApplication\\V1\\Rpc\\PluginActivate\\Controller' => 'ZourceApplication\\V1\\Rpc\\PluginActivate\\PluginActivateControllerFactory',
            'ZourceApplication\\V1\\Rpc\\PluginDeactivate\\Controller' => 'ZourceApplication\\V1\\Rpc\\PluginDeactivate\\PluginDeactivateControllerFactory',
        ),
    ),
    'input_filter_specs' => array(
        'ZourceApplication\\V1\\Rest\\Dashboard\\Validator' => array(
            array(
                'required' => true,
                'validators' => array(),
                'filters' => array(),
                'name' => 'name',
                'description' => 'The name of the dashboard.',
            ),
        ),
        'ZourceApplication\\V1\\Rest\\MailIncoming\\Validator' => array(
            array(
                'required' => true,
                'validators' => array(
                    array(
                        'name' => \Zend\Validator\InArray::class,
                        'options' => array(
                            'haystack' => array(
                                'imap',
                            ),
                        ),
                    ),
                ),
                'filters' => array(),
                'name' => 'type',
                'description' => 'The type of connection to make.',
            ),
            array(
                'required' => true,
                'validators' => array(),
                'filters' => array(),
                'name' => 'hostname',
                'description' => 'The hostname to connect to.',
            ),
            array(
                'required' => true,
                'validators' => array(
                    array(
                        'name' => \Zend\Validator\Digits::class,
                        'options' => array(),
                    ),
                ),
                'filters' => array(),
                'name' => 'port',
                'description' => 'The port to connect to.',
            ),
            array(
                'required' => true,
                'validators' => array(),
                'filters' => array(),
                'name' => 'username',
                'description' => 'The username to authenticate with.',
            ),
            array(
                'required' => true,
                'validators' => array(),
                'filters' => array(),
                'name' => 'password',
                'description' => 'The password to authenticate with.',
            ),
            array(
                'required' => false,
                'validators' => array(
                    array(
                        'name' => \Zend\Validator\InArray::class,
                        'options' => array(
                            'haystack' => array(
                                'ssl',
                                'tls',
                            ),
                        ),
                    ),
                ),
                'filters' => array(),
                'name' => 'ssl',
                'description' => 'The ssl method.',
            ),
        ),
        'ZourceApplication\\V1\\Rest\\Setting\\Validator' => array(
            array(
                'required' => true,
                'validators' => array(),
                'filters' => array(),
                'name' => 'value',
                'description' => 'The value to set.',
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'ZourceApplication\\V1\\Rest\\Cache\\CacheResource' => 'ZourceApplication\\V1\\Rest\\Cache\\CacheResourceFactory',
            'ZourceApplication\\V1\\Rest\\Dashboard\\DashboardResource' => 'ZourceApplication\\V1\\Rest\\Dashboard\\DashboardResourceFactory',
            'ZourceApplication\\V1\\Rest\\FieldType\\FieldTypeResource' => 'ZourceApplication\\V1\\Rest\\FieldType\\FieldTypeResourceFactory',
            'ZourceApplication\\V1\\Rest\\Gadget\\GadgetResource' => 'ZourceApplication\\V1\\Rest\\Gadget\\GadgetResourceFactory',
            'ZourceApplication\\V1\\Rest\\GadgetContainer\\GadgetContainerResource' => 'ZourceApplication\\V1\\Rest\\GadgetContainer\\GadgetContainerResourceFactory',
            'ZourceApplication\\V1\\Rest\\GadgetType\\GadgetTypeResource' => 'ZourceApplication\\V1\\Rest\\GadgetType\\GadgetTypeResourceFactory',
            'ZourceApplication\\V1\\Rest\\MailIncoming\\MailIncomingResource' => 'ZourceApplication\\V1\\Rest\\MailIncoming\\MailIncomingResourceFactory',
            'ZourceApplication\\V1\\Rest\\MailOutgoing\\MailOutgoingResource' => 'ZourceApplication\\V1\\Rest\\MailOutgoing\\MailOutgoingResourceFactory',
            'ZourceApplication\\V1\\Rest\\Plugin\\PluginResource' => 'ZourceApplication\\V1\\Rest\\Plugin\\PluginResourceFactory',
            'ZourceApplication\\V1\\Rest\\Setting\\SettingResource' => 'ZourceApplication\\V1\\Rest\\Setting\\SettingResourceFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'zource-application.rest.cache' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/cache[/:cache_id]',
                    'defaults' => array(
                        'controller' => 'ZourceApplication\\V1\\Rest\\Cache\\Controller',
                    ),
                ),
            ),
            'zource-application.rest.dashboard' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/dashboard[/:dashboard_id]',
                    'defaults' => array(
                        'controller' => 'ZourceApplication\\V1\\Rest\\Dashboard\\Controller',
                    ),
                ),
            ),
            'zource-application.rest.field-type' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/field-type[/:field_type_id]',
                    'defaults' => array(
                        'controller' => 'ZourceApplication\\V1\\Rest\\FieldType\\Controller',
                    ),
                ),
            ),
            'zource-application.rest.gadget' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/gadget[/:gadget_id]',
                    'defaults' => array(
                        'controller' => 'ZourceApplication\\V1\\Rest\\Gadget\\Controller',
                    ),
                ),
            ),
            'zource-application.rest.gadget-container' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/gadget-container[/:gadget_container_id]',
                    'defaults' => array(
                        'controller' => 'ZourceApplication\\V1\\Rest\\GadgetContainer\\Controller',
                    ),
                ),
            ),
            'zource-application.rest.gadget-type' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/gadget-type[/:gadget_type_id]',
                    'defaults' => array(
                        'controller' => 'ZourceApplication\\V1\\Rest\\GadgetType\\Controller',
                    ),
                ),
            ),
            'zource-application.rest.mail-incoming' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/mail-incoming[/:mail_incoming_id]',
                    'defaults' => array(
                        'controller' => 'ZourceApplication\\V1\\Rest\\MailIncoming\\Controller',
                    ),
                ),
            ),
            'zource-application.rest.mail-outgoing' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/mail-outgoing[/:mail_outgoing_id]',
                    'defaults' => array(
                        'controller' => 'ZourceApplication\\V1\\Rest\\MailOutgoing\\Controller',
                    ),
                ),
            ),
            'zource-application.rest.plugin' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/plugin[/:plugin_id]',
                    'defaults' => array(
                        'controller' => 'ZourceApplication\\V1\\Rest\\Plugin\\Controller',
                    ),
                ),
            ),
            'zource-application.rest.setting' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/setting[/:setting_id]',
                    'defaults' => array(
                        'controller' => 'ZourceApplication\\V1\\Rest\\Setting\\Controller',
                    ),
                ),
            ),
            'zource-application.rpc.plugin-activate' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/plugin/activate/:plugin_id',
                    'defaults' => array(
                        'controller' => 'ZourceApplication\\V1\\Rpc\\PluginActivate\\Controller',
                        'action' => 'pluginActivate',
                    ),
                ),
            ),
            'zource-application.rpc.plugin-deactivate' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/plugin/deactivate/:plugin_id',
                    'defaults' => array(
                        'controller' => 'ZourceApplication\\V1\\Rpc\\PluginDeactivate\\Controller',
                        'action' => 'pluginDeactivate',
                    ),
                ),
            ),
        ),
    ),
    'zf-content-validation' => array(
        'ZourceApplication\\V1\\Rest\\Dashboard\\Controller' => array(
            'input_filter' => 'ZourceApplication\\V1\\Rest\\Dashboard\\Validator',
        ),
        'ZourceApplication\\V1\\Rest\\MailIncoming\\Controller' => array(
            'input_filter' => 'ZourceApplication\\V1\\Rest\\MailIncoming\\Validator',
        ),
        'ZourceApplication\\V1\\Rest\\Setting\\Controller' => array(
            'input_filter' => 'ZourceApplication\\V1\\Rest\\Setting\\Validator',
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'zource-application.rest.cache',
            1 => 'zource-application.rest.dashboard',
            2 => 'zource-application.rest.field-type',
            3 => 'zource-application.rest.gadget',
            4 => 'zource-application.rest.gadget-container',
            5 => 'zource-application.rest.gadget-type',
            6 => 'zource-application.rest.mail-incoming',
            7 => 'zource-application.rest.mail-outgoing',
            8 => 'zource-application.rest.plugin',
            9 => 'zource-application.rest.setting',
            10 => 'zource-application.rpc.plugin-activate',
        ),
    ),
    'zf-rest' => array(
        'ZourceApplication\\V1\\Rest\\Cache\\Controller' => array(
            'listener' => 'ZourceApplication\\V1\\Rest\\Cache\\CacheResource',
            'route_name' => 'zource-application.rest.cache',
            'route_identifier_name' => 'cache_id',
            'collection_name' => 'cache',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'DELETE',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => 'page_size',
            'entity_class' => 'ZourceApplication\\V1\\Rest\\Cache\\CacheEntity',
            'collection_class' => 'ZourceApplication\\V1\\Rest\\Cache\\CacheCollection',
            'service_name' => 'Cache',
        ),
        'ZourceApplication\\V1\\Rest\\Dashboard\\Controller' => array(
            'listener' => 'ZourceApplication\\V1\\Rest\\Dashboard\\DashboardResource',
            'route_name' => 'zource-application.rest.dashboard',
            'route_identifier_name' => 'dashboard_id',
            'collection_name' => 'dashboard',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'DELETE',
                2 => 'PATCH',
                3 => 'PUT',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => 'page_size',
            'entity_class' => 'ZourceApplication\\V1\\Rest\\Dashboard\\DashboardEntity',
            'collection_class' => 'ZourceApplication\\V1\\Rest\\Dashboard\\DashboardCollection',
            'service_name' => 'Dashboard',
        ),
        'ZourceApplication\\V1\\Rest\\FieldType\\Controller' => array(
            'listener' => 'ZourceApplication\\V1\\Rest\\FieldType\\FieldTypeResource',
            'route_name' => 'zource-application.rest.field-type',
            'route_identifier_name' => 'field_type_id',
            'collection_name' => 'field-type',
            'entity_http_methods' => array(
                0 => 'GET',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => 'page_size',
            'entity_class' => 'ZourceApplication\\V1\\Rest\\FieldType\\FieldTypeEntity',
            'collection_class' => 'ZourceApplication\\V1\\Rest\\FieldType\\FieldTypeCollection',
            'service_name' => 'Field Type',
        ),
        'ZourceApplication\\V1\\Rest\\Gadget\\Controller' => array(
            'listener' => 'ZourceApplication\\V1\\Rest\\Gadget\\GadgetResource',
            'route_name' => 'zource-application.rest.gadget',
            'route_identifier_name' => 'gadget_id',
            'collection_name' => 'gadget',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'DELETE',
                2 => 'PATCH',
                3 => 'PUT',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => 'page_size',
            'entity_class' => 'ZourceApplication\\V1\\Rest\\Gadget\\GadgetEntity',
            'collection_class' => 'ZourceApplication\\V1\\Rest\\Gadget\\GadgetCollection',
            'service_name' => 'Gadget',
        ),
        'ZourceApplication\\V1\\Rest\\GadgetContainer\\Controller' => array(
            'listener' => 'ZourceApplication\\V1\\Rest\\GadgetContainer\\GadgetContainerResource',
            'route_name' => 'zource-application.rest.gadget-container',
            'route_identifier_name' => 'gadget_container_id',
            'collection_name' => 'gadget-container',
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
            'entity_class' => 'ZourceApplication\\V1\\Rest\\GadgetContainer\\GadgetContainerEntity',
            'collection_class' => 'ZourceApplication\\V1\\Rest\\GadgetContainer\\GadgetContainerCollection',
            'service_name' => 'Gadget Container',
        ),
        'ZourceApplication\\V1\\Rest\\GadgetType\\Controller' => array(
            'listener' => 'ZourceApplication\\V1\\Rest\\GadgetType\\GadgetTypeResource',
            'route_name' => 'zource-application.rest.gadget-type',
            'route_identifier_name' => 'gadget_type_id',
            'collection_name' => 'gadget-type',
            'entity_http_methods' => array(
                0 => 'GET',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => 'page_size',
            'entity_class' => 'ZourceApplication\\V1\\Rest\\GadgetType\\GadgetTypeEntity',
            'collection_class' => 'ZourceApplication\\V1\\Rest\\GadgetType\\GadgetTypeCollection',
            'service_name' => 'Gadget Type',
        ),
        'ZourceApplication\\V1\\Rest\\MailIncoming\\Controller' => array(
            'listener' => 'ZourceApplication\\V1\\Rest\\MailIncoming\\MailIncomingResource',
            'route_name' => 'zource-application.rest.mail-incoming',
            'route_identifier_name' => 'mail_incoming_id',
            'collection_name' => 'mail-incoming',
            'entity_http_methods' => array(
                0 => 'DELETE',
                1 => 'GET',
                2 => 'PATCH',
                3 => 'PUT',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => 'page_size',
            'entity_class' => 'ZourceApplication\\V1\\Rest\\MailIncoming\\MailIncomingEntity',
            'collection_class' => 'ZourceApplication\\V1\\Rest\\MailIncoming\\MailIncomingCollection',
            'service_name' => 'Mail Incoming',
        ),
        'ZourceApplication\\V1\\Rest\\MailOutgoing\\Controller' => array(
            'listener' => 'ZourceApplication\\V1\\Rest\\MailOutgoing\\MailOutgoingResource',
            'route_name' => 'zource-application.rest.mail-outgoing',
            'route_identifier_name' => 'mail_outgoing_id',
            'collection_name' => 'mail-outgoing',
            'entity_http_methods' => array(
                0 => 'DELETE',
                1 => 'GET',
                2 => 'PATCH',
                3 => 'PUT',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => 'page_size',
            'entity_class' => 'ZourceApplication\\V1\\Rest\\MailOutgoing\\MailOutgoingEntity',
            'collection_class' => 'ZourceApplication\\V1\\Rest\\MailOutgoing\\MailOutgoingCollection',
            'service_name' => 'Mail Outgoing',
        ),
        'ZourceApplication\\V1\\Rest\\Plugin\\Controller' => array(
            'listener' => 'ZourceApplication\\V1\\Rest\\Plugin\\PluginResource',
            'route_name' => 'zource-application.rest.plugin',
            'route_identifier_name' => 'plugin_id',
            'collection_name' => 'plugin',
            'entity_http_methods' => array(
                0 => 'DELETE',
                1 => 'GET',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => 'page_size',
            'entity_class' => 'ZourceApplication\\V1\\Rest\\Plugin\\PluginEntity',
            'collection_class' => 'ZourceApplication\\V1\\Rest\\Plugin\\PluginCollection',
            'service_name' => 'Plugin',
        ),
        'ZourceApplication\\V1\\Rest\\Setting\\Controller' => array(
            'listener' => 'ZourceApplication\\V1\\Rest\\Setting\\SettingResource',
            'route_name' => 'zource-application.rest.setting',
            'route_identifier_name' => 'setting_id',
            'collection_name' => 'mail-setting',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PUT',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => 'page_size',
            'entity_class' => 'ZourceApplication\\V1\\Rest\\Setting\\SettingEntity',
            'collection_class' => 'ZourceApplication\\V1\\Rest\\Setting\\SettingCollection',
            'service_name' => 'Setting',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'ZourceApplication\\V1\\Rest\\Cache\\Controller' => 'HalJson',
            'ZourceApplication\\V1\\Rest\\Dashboard\\Controller' => 'HalJson',
            'ZourceApplication\\V1\\Rest\\FieldType\\Controller' => 'HalJson',
            'ZourceApplication\\V1\\Rest\\Gadget\\Controller' => 'HalJson',
            'ZourceApplication\\V1\\Rest\\GadgetContainer\\Controller' => 'HalJson',
            'ZourceApplication\\V1\\Rest\\GadgetType\\Controller' => 'HalJson',
            'ZourceApplication\\V1\\Rest\\MailIncoming\\Controller' => 'HalJson',
            'ZourceApplication\\V1\\Rest\\MailOutgoing\\Controller' => 'HalJson',
            'ZourceApplication\\V1\\Rest\\Plugin\\Controller' => 'HalJson',
            'ZourceApplication\\V1\\Rest\\Setting\\Controller' => 'HalJson',
            'ZourceApplication\\V1\\Rpc\\PluginActivate\\Controller' => 'Json',
            'ZourceApplication\\V1\\Rpc\\PluginDeactivate\\Controller' => 'Json',
        ),
        'accept_whitelist' => array(
            'ZourceApplication\\V1\\Rest\\Cache\\Controller' => array(
                0 => 'application/vnd.zource-application.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'ZourceApplication\\V1\\Rest\\Dashboard\\Controller' => array(
                0 => 'application/vnd.zource-application.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'ZourceApplication\\V1\\Rest\\FieldType\\Controller' => array(
                0 => 'application/vnd.zource-application.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'ZourceApplication\\V1\\Rest\\Gadget\\Controller' => array(
                0 => 'application/vnd.zource-application.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'ZourceApplication\\V1\\Rest\\GadgetContainer\\Controller' => array(
                0 => 'application/vnd.zource-application.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'ZourceApplication\\V1\\Rest\\GadgetType\\Controller' => array(
                0 => 'application/vnd.zource-application.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'ZourceApplication\\V1\\Rest\\MailIncoming\\Controller' => array(
                0 => 'application/vnd.zource-application.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'ZourceApplication\\V1\\Rest\\MailOutgoing\\Controller' => array(
                0 => 'application/vnd.zource-application.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'ZourceApplication\\V1\\Rest\\Plugin\\Controller' => array(
                0 => 'application/vnd.zource-application.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'ZourceApplication\\V1\\Rest\\Setting\\Controller' => array(
                0 => 'application/vnd.zource-application.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'ZourceApplication\\V1\\Rpc\\PluginActivate\\Controller' => array(
                0 => 'application/vnd.zource-application.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
            'ZourceApplication\\V1\\Rpc\\PluginDeactivate\\Controller' => array(
                0 => 'application/vnd.zource-application.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
        ),
        'content_type_whitelist' => array(
            'ZourceApplication\\V1\\Rest\\Cache\\Controller' => array(
                0 => 'application/vnd.zource-application.v1+json',
                1 => 'application/json',
            ),
            'ZourceApplication\\V1\\Rest\\Dashboard\\Controller' => array(
                0 => 'application/vnd.zource-application.v1+json',
                1 => 'application/json',
            ),
            'ZourceApplication\\V1\\Rest\\FieldType\\Controller' => array(
                0 => 'application/vnd.zource-application.v1+json',
                1 => 'application/json',
            ),
            'ZourceApplication\\V1\\Rest\\Gadget\\Controller' => array(
                0 => 'application/vnd.zource-application.v1+json',
                1 => 'application/json',
            ),
            'ZourceApplication\\V1\\Rest\\GadgetContainer\\Controller' => array(
                0 => 'application/vnd.zource-application.v1+json',
                1 => 'application/json',
            ),
            'ZourceApplication\\V1\\Rest\\GadgetType\\Controller' => array(
                0 => 'application/vnd.zource-application.v1+json',
                1 => 'application/json',
            ),
            'ZourceApplication\\V1\\Rest\\MailIncoming\\Controller' => array(
                0 => 'application/vnd.zource-application.v1+json',
                1 => 'application/json',
            ),
            'ZourceApplication\\V1\\Rest\\MailOutgoing\\Controller' => array(
                0 => 'application/vnd.zource-application.v1+json',
                1 => 'application/json',
            ),
            'ZourceApplication\\V1\\Rest\\Plugin\\Controller' => array(
                0 => 'application/vnd.zource-application.v1+json',
                1 => 'application/json',
            ),
            'ZourceApplication\\V1\\Rest\\Setting\\Controller' => array(
                0 => 'application/vnd.zource-application.v1+json',
                1 => 'application/json',
            ),
            'ZourceApplication\\V1\\Rpc\\PluginActivate\\Controller' => array(
                0 => 'application/vnd.zource-application.v1+json',
                1 => 'application/json',
            ),
            'ZourceApplication\\V1\\Rpc\\PluginDeactivate\\Controller' => array(
                0 => 'application/vnd.zource-application.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'ZourceApplication\\V1\\Rest\\Cache\\CacheEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-application.rest.cache',
                'route_identifier_name' => 'cache_id',
                'hydrator' => 'Zend\\Hydrator\\ObjectProperty',
            ),
            'ZourceApplication\\V1\\Rest\\Cache\\CacheCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-application.rest.cache',
                'route_identifier_name' => 'cache_id',
                'is_collection' => true,
            ),
            'ZourceApplication\\V1\\Rest\\Dashboard\\DashboardEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-application.rest.dashboard',
                'route_identifier_name' => 'dashboard_id',
                'hydrator' => 'Zend\\Hydrator\\ObjectProperty',
            ),
            'ZourceApplication\\V1\\Rest\\Dashboard\\DashboardCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-application.rest.dashboard',
                'route_identifier_name' => 'dashboard_id',
                'is_collection' => true,
            ),
            'ZourceApplication\\V1\\Rest\\FieldType\\FieldTypeEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-application.rest.field-type',
                'route_identifier_name' => 'field_type_id',
                'hydrator' => 'Zend\\Hydrator\\ObjectProperty',
            ),
            'ZourceApplication\\V1\\Rest\\FieldType\\FieldTypeCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-application.rest.field-type',
                'route_identifier_name' => 'field_type_id',
                'is_collection' => true,
            ),
            'ZourceApplication\\V1\\Rest\\Gadget\\GadgetEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-application.rest.gadget',
                'route_identifier_name' => 'gadget_id',
                'hydrator' => 'Zend\\Hydrator\\ObjectProperty',
            ),
            'ZourceApplication\\V1\\Rest\\Gadget\\GadgetCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-application.rest.gadget',
                'route_identifier_name' => 'gadget_id',
                'is_collection' => true,
            ),
            'ZourceApplication\\V1\\Rest\\GadgetContainer\\GadgetContainerEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-application.rest.gadget-container',
                'route_identifier_name' => 'gadget_container_id',
                'hydrator' => 'Zend\\Hydrator\\ObjectProperty',
            ),
            'ZourceApplication\\V1\\Rest\\GadgetContainer\\GadgetContainerCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-application.rest.gadget-container',
                'route_identifier_name' => 'gadget_container_id',
                'is_collection' => true,
            ),
            'ZourceApplication\\V1\\Rest\\GadgetType\\GadgetTypeEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-application.rest.gadget-type',
                'route_identifier_name' => 'gadget_type_id',
                'hydrator' => 'Zend\\Hydrator\\ObjectProperty',
            ),
            'ZourceApplication\\V1\\Rest\\GadgetType\\GadgetTypeCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-application.rest.gadget-type',
                'route_identifier_name' => 'gadget_type_id',
                'is_collection' => true,
            ),
            'ZourceApplication\\V1\\Rest\\MailIncoming\\MailIncomingEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-application.rest.mail-incoming',
                'route_identifier_name' => 'mail_incoming_id',
                'hydrator' => 'Zend\\Hydrator\\ObjectProperty',
            ),
            'ZourceApplication\\V1\\Rest\\MailIncoming\\MailIncomingCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-application.rest.mail-incoming',
                'route_identifier_name' => 'mail_incoming_id',
                'is_collection' => true,
            ),
            'ZourceApplication\\V1\\Rest\\MailOutgoing\\MailOutgoingEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-application.rest.mail-outgoing',
                'route_identifier_name' => 'mail_outgoing_id',
                'hydrator' => 'Zend\\Hydrator\\ObjectProperty',
            ),
            'ZourceApplication\\V1\\Rest\\MailOutgoing\\MailOutgoingCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-application.rest.mail-outgoing',
                'route_identifier_name' => 'mail_outgoing_id',
                'is_collection' => true,
            ),
            'ZourceApplication\\V1\\Rest\\Plugin\\PluginEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-application.rest.plugin',
                'route_identifier_name' => 'plugin_id',
                'hydrator' => 'Zend\\Hydrator\\ObjectProperty',
            ),
            'ZourceApplication\\V1\\Rest\\Plugin\\PluginCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-application.rest.plugin',
                'route_identifier_name' => 'plugin_id',
                'is_collection' => true,
            ),
            'ZourceApplication\\V1\\Rest\\Setting\\SettingEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-application.rest.setting',
                'route_identifier_name' => 'setting_id',
                'hydrator' => 'Zend\\Hydrator\\ObjectProperty',
            ),
            'ZourceApplication\\V1\\Rest\\Setting\\SettingCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-application.rest.setting',
                'route_identifier_name' => 'setting_id',
                'is_collection' => true,
            ),
        ),
    ),
    'zf-mvc-auth' => array(
        'authorization' => array(
            'ZourceApplication\\V1\\Rest\\Cache\\Controller' => array(
                'collection' => array(
                    'GET' => true,
                    'POST' => true,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ),
                'entity' => array(
                    'GET' => true,
                    'POST' => true,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ),
            ),
            'ZourceApplication\\V1\\Rest\\Dashboard\\Controller' => array(
                'collection' => array(
                    'GET' => true,
                    'POST' => true,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ),
                'entity' => array(
                    'GET' => true,
                    'POST' => true,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ),
            ),
            'ZourceApplication\\V1\\Rest\\FieldType\\Controller' => array(
                'collection' => array(
                    'GET' => true,
                    'POST' => true,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ),
                'entity' => array(
                    'GET' => true,
                    'POST' => true,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ),
            ),
            'ZourceApplication\\V1\\Rest\\Gadget\\Controller' => array(
                'collection' => array(
                    'GET' => true,
                    'POST' => true,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ),
                'entity' => array(
                    'GET' => true,
                    'POST' => true,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ),
            ),
            'ZourceApplication\\V1\\Rest\\GadgetContainer\\Controller' => array(
                'collection' => array(
                    'GET' => true,
                    'POST' => true,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ),
                'entity' => array(
                    'GET' => true,
                    'POST' => true,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ),
            ),
            'ZourceApplication\\V1\\Rest\\GadgetType\\Controller' => array(
                'collection' => array(
                    'GET' => true,
                    'POST' => true,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ),
                'entity' => array(
                    'GET' => true,
                    'POST' => true,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ),
            ),
            'ZourceApplication\\V1\\Rest\\MailIncoming\\Controller' => array(
                'collection' => array(
                    'GET' => true,
                    'POST' => true,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ),
                'entity' => array(
                    'GET' => true,
                    'POST' => true,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ),
            ),
            'ZourceApplication\\V1\\Rest\\MailOutgoing\\Controller' => array(
                'collection' => array(
                    'GET' => true,
                    'POST' => true,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ),
                'entity' => array(
                    'GET' => true,
                    'POST' => true,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ),
            ),
            'ZourceApplication\\V1\\Rest\\Plugin\\Controller' => array(
                'collection' => array(
                    'GET' => true,
                    'POST' => true,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ),
                'entity' => array(
                    'GET' => true,
                    'POST' => true,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ),
            ),
            'ZourceApplication\\V1\\Rest\\Setting\\Controller' => array(
                'collection' => array(
                    'GET' => true,
                    'POST' => true,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ),
                'entity' => array(
                    'GET' => true,
                    'POST' => true,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ),
            ),
        ),
    ),
    'zf-rpc' => array(
        'ZourceApplication\\V1\\Rpc\\PluginActivate\\Controller' => array(
            'service_name' => 'PluginActivate',
            'http_methods' => array(
                0 => 'POST',
            ),
            'route_name' => 'zource-application.rpc.plugin-activate',
        ),
        'ZourceApplication\\V1\\Rpc\\PluginDeactivate\\Controller' => array(
            'service_name' => 'PluginDeactivate',
            'http_methods' => array(
                0 => 'POST',
            ),
            'route_name' => 'zource-application.rpc.plugin-deactivate',
        ),
    ),
);
