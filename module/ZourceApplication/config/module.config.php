<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'ZourceApplication\\V1\\Rest\\Cache\\CacheResource' => 'ZourceApplication\\V1\\Rest\\Cache\\CacheResourceFactory',
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
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'zource-application.rest.cache',
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
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'ZourceApplication\\V1\\Rest\\Cache\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'ZourceApplication\\V1\\Rest\\Cache\\Controller' => array(
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
        ),
    ),
);
