<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'ZourceApplication\\V1\\Rest\\Cache\\CacheResource' => 'ZourceApplication\\V1\\Rest\\Cache\\CacheResourceFactory',
            'ZourceApplication\\V1\\Rest\\Dashboard\\DashboardResource' => 'ZourceApplication\\V1\\Rest\\Dashboard\\DashboardResourceFactory',
            'ZourceApplication\\V1\\Rest\\FieldType\\FieldTypeResource' => 'ZourceApplication\\V1\\Rest\\FieldType\\FieldTypeResourceFactory',
            'ZourceApplication\\V1\\Rest\\Gadget\\GadgetResource' => 'ZourceApplication\\V1\\Rest\\Gadget\\GadgetResourceFactory',
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
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'zource-application.rest.cache',
            0 => 'zource-application.rest.dashboard',
            0 => 'zource-application.rest.field-type',
            0 => 'zource-application.rest.gadget',
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
            ),
            'collection_http_methods' => array(
                0 => 'GET',
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
            'service_name' => 'Field-Type',
        ),
        'ZourceApplication\\V1\\Rest\\Gadget\\Controller' => array(
            'listener' => 'ZourceApplication\\V1\\Rest\\Gadget\\GadgetResource',
            'route_name' => 'zource-application.rest.gadget',
            'route_identifier_name' => 'gadget_id',
            'collection_name' => 'gadget',
            'entity_http_methods' => array(
                0 => 'GET',
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
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'ZourceApplication\\V1\\Rest\\Cache\\Controller' => 'HalJson',
            'ZourceApplication\\V1\\Rest\\Dashboard\\Controller' => 'HalJson',
            'ZourceApplication\\V1\\Rest\\FieldType\\Controller' => 'HalJson',
            'ZourceApplication\\V1\\Rest\\Gadget\\Controller' => 'HalJson',
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
        ),
    ),
);
