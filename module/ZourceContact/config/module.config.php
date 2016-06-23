<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'ZourceContact\\V1\\Rest\\Contact\\ContactResource' => 'ZourceContact\\V1\\Rest\\Contact\\ContactResourceFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'zource-contact.rest.contact' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/contacts[/:contact_id]',
                    'defaults' => array(
                        'controller' => 'ZourceContact\\V1\\Rest\\Contact\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'zource-contact.rest.contact',
        ),
    ),
    'zf-rest' => array(
        'ZourceContact\\V1\\Rest\\Contact\\Controller' => array(
            'listener' => 'ZourceContact\\V1\\Rest\\Contact\\ContactResource',
            'route_name' => 'zource-contact.rest.contact',
            'route_identifier_name' => 'contact_id',
            'collection_name' => 'contact',
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
            'entity_class' => 'ZourceContact\\V1\\Rest\\Contact\\ContactEntity',
            'collection_class' => 'ZourceContact\\V1\\Rest\\Contact\\ContactCollection',
            'service_name' => 'Contact',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'ZourceContact\\V1\\Rest\\Contact\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'ZourceContact\\V1\\Rest\\Contact\\Controller' => array(
                0 => 'application/vnd.zource-contact.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'ZourceContact\\V1\\Rest\\Contact\\Controller' => array(
                0 => 'application/vnd.zource-contact.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'ZourceContact\\V1\\Rest\\Contact\\ContactEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-contact.rest.contact',
                'route_identifier_name' => 'contact_id',
                'hydrator' => 'Zend\\Hydrator\\ArraySerializable',
            ),
            'ZourceContact\\V1\\Rest\\Contact\\ContactCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-contact.rest.contact',
                'route_identifier_name' => 'contact_id',
                'is_collection' => true,
            ),
        ),
    ),
);
