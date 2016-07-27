<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'ZourceContact\\V1\\Rest\\Contact\\ContactResource' => 'ZourceContact\\V1\\Rest\\Contact\\ContactResourceFactory',
            'ZourceContact\\V1\\Rest\\ContactCompany\\ContactResource' => 'ZourceContact\\V1\\Rest\\ContactCompany\\ContactResourceFactory',
            'ZourceContact\\V1\\Rest\\ContactPerson\\ContactResource' => 'ZourceContact\\V1\\Rest\\ContactPerson\\ContactResourceFactory',
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
                    'constraints' => array(
                        'contact_id' => '[a-f0-9]{8}-?[a-f0-9]{4}-?4[a-f0-9]{3}-?[89ab][a-f0-9]{3}-?[a-f0-9]{12}',
                    ),
                ),
            ),
            'zource-contact.rest.contact-company' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/contacts/companies[/:contact_id]',
                    'defaults' => array(
                        'controller' => 'ZourceContact\\V1\\Rest\\ContactCompany\\Controller',
                    ),
                    'constraints' => array(
                        'contact_id' => '[a-f0-9]{8}-?[a-f0-9]{4}-?4[a-f0-9]{3}-?[89ab][a-f0-9]{3}-?[a-f0-9]{12}',
                    ),
                ),
            ),
            'zource-contact.rest.contact-person' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/contacts/people[/:contact_id]',
                    'defaults' => array(
                        'controller' => 'ZourceContact\\V1\\Rest\\ContactPerson\\Controller',
                    ),
                    'constraints' => array(
                        'contact_id' => '[a-f0-9]{8}-?[a-f0-9]{4}-?4[a-f0-9]{3}-?[89ab][a-f0-9]{3}-?[a-f0-9]{12}',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'zource-contact.rest.contact',
            1 => 'zource-contact.rest.contact-company',
            2 => 'zource-contact.rest.contact-person',
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
            ),
            'collection_http_methods' => array(
                0 => 'GET',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => 'page_size',
            'entity_class' => 'ZourceContact\\V1\\Rest\\Contact\\ContactEntity',
            'collection_class' => 'ZourceContact\\V1\\Rest\\Contact\\ContactCollection',
            'service_name' => 'Contact',
        ),
        'ZourceContact\\V1\\Rest\\ContactCompany\\Controller' => array(
            'listener' => 'ZourceContact\\V1\\Rest\\ContactCompany\\ContactResource',
            'route_name' => 'zource-contact.rest.contact-company',
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
            'page_size_param' => 'page_size',
            'entity_class' => 'ZourceContact\\V1\\Rest\\ContactCompany\\ContactEntity',
            'collection_class' => 'ZourceContact\\V1\\Rest\\ContactCompany\\ContactCollection',
            'service_name' => 'ContactCompany',
        ),
        'ZourceContact\\V1\\Rest\\ContactPerson\\Controller' => array(
            'listener' => 'ZourceContact\\V1\\Rest\\ContactPerson\\ContactResource',
            'route_name' => 'zource-contact.rest.contact-person',
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
            'page_size_param' => 'page_size',
            'entity_class' => 'ZourceContact\\V1\\Rest\\ContactPerson\\ContactEntity',
            'collection_class' => 'ZourceContact\\V1\\Rest\\ContactPerson\\ContactCollection',
            'service_name' => 'ContactPerson',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'ZourceContact\\V1\\Rest\\Contact\\Controller' => 'HalJson',
            'ZourceContact\\V1\\Rest\\ContactCompany\\Controller' => 'HalJson',
            'ZourceContact\\V1\\Rest\\ContactPerson\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'ZourceContact\\V1\\Rest\\Contact\\Controller' => array(
                0 => 'application/vnd.zource-contact.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'ZourceContact\\V1\\Rest\\ContactCompany\\Controller' => array(
                0 => 'application/vnd.zource-contact.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'ZourceContact\\V1\\Rest\\ContactPerson\\Controller' => array(
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
            'ZourceContact\\V1\\Rest\\ContactCompany\\Controller' => array(
                0 => 'application/vnd.zource-contact.v1+json',
                1 => 'application/json',
            ),
            'ZourceContact\\V1\\Rest\\ContactPerson\\Controller' => array(
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
                'hydrator' => 'Zend\\Hydrator\\ObjectProperty',
            ),
            'ZourceContact\\V1\\Rest\\Contact\\ContactCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-contact.rest.contact',
                'route_identifier_name' => 'contact_id',
                'is_collection' => true,
            ),
            'ZourceContact\\V1\\Rest\\ContactCompany\\ContactEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-contact.rest.contact-company',
                'route_identifier_name' => 'contact_id',
                'hydrator' => 'Zend\\Hydrator\\ObjectProperty',
            ),
            'ZourceContact\\V1\\Rest\\ContactCompany\\ContactCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-contact.rest.contact-company',
                'route_identifier_name' => 'contact_id',
                'is_collection' => true,
            ),
            'ZourceContact\\V1\\Rest\\ContactPerson\\ContactEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-contact.rest.contact-person',
                'route_identifier_name' => 'contact_id',
                'hydrator' => 'Zend\\Hydrator\\ObjectProperty',
            ),
            'ZourceContact\\V1\\Rest\\ContactPerson\\ContactCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-contact.rest.contact-person',
                'route_identifier_name' => 'contact_id',
                'is_collection' => true,
            ),
        ),
    ),
);
