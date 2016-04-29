<?php
return array(
    'input_filter_specs' => array(
        'ZourceProject\\V1\\Rest\\Project\\Validator' => array(
            0 => array(
                'required' => false,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\I18n\\Validator\\IsInt',
                        'options' => array(),
                    ),
                ),
                'filters' => array(),
                'name' => 'id',
                'description' => 'The identifier of the project.',
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
                'description' => 'The name of the project.',
            ),
            2 => array(
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
                'name' => 'project_key',
                'description' => 'The project key which identifies the project.',
            ),
            3 => array(
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
                'name' => 'description',
                'description' => 'The description of the project.',
            ),
        ),
        'ZourceProject\\V1\\Rest\\Category\\Validator' => array(
            0 => array(
                'required' => false,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\I18n\\Validator\\IsInt',
                        'options' => array(),
                    ),
                ),
                'filters' => array(),
                'name' => 'id',
                'description' => 'The identifier of the project category.',
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
                'description' => 'The name of the project category.',
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'ZourceProject\\V1\\Rest\\Category\\CategoryResource' => 'ZourceProject\\V1\\Rest\\Category\\CategoryResourceFactory',
            'ZourceProject\\V1\\Rest\\Project\\ProjectResource' => 'ZourceProject\\V1\\Rest\\Project\\ProjectResourceFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'zource-project.rest.category' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/project/category[/:category_id]',
                    'defaults' => array(
                        'controller' => 'ZourceProject\\V1\\Rest\\Category\\Controller',
                    ),
                    'constraints' => array(
                        'category_id' => '[0-9]+',
                    ),
                ),
            ),
            'zource-project.rest.project' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/project[/:project_id]',
                    'defaults' => array(
                        'controller' => 'ZourceProject\\V1\\Rest\\Project\\Controller',
                    ),
                    'constraints' => array(
                        'project_id' => '[0-9]+',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'zource-project.rest.category',
            1 => 'zource-project.rest.project',
        ),
    ),
    'zf-rest' => array(
        'ZourceProject\\V1\\Rest\\Category\\Controller' => array(
            'listener' => 'ZourceProject\\V1\\Rest\\Category\\CategoryResource',
            'route_name' => 'zource-project.rest.category',
            'route_identifier_name' => 'category_id',
            'collection_name' => 'category',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
                2 => 'PUT',
                3 => 'PATCH',
                4 => 'DELETE',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'ZourceProject\\V1\\Rest\\Category\\CategoryEntity',
            'collection_class' => 'ZourceProject\\V1\\Rest\\Category\\CategoryCollection',
            'service_name' => 'Category',
        ),
        'ZourceProject\\V1\\Rest\\Project\\Controller' => array(
            'listener' => 'ZourceProject\\V1\\Rest\\Project\\ProjectResource',
            'route_name' => 'zource-project.rest.project',
            'route_identifier_name' => 'project_id',
            'collection_name' => 'project',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
                2 => 'PUT',
                3 => 'PATCH',
                4 => 'DELETE',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'ZourceProject\\V1\\Rest\\Project\\ProjectEntity',
            'collection_class' => 'ZourceProject\\V1\\Rest\\Project\\ProjectCollection',
            'service_name' => 'Project',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'ZourceProject\\V1\\Rest\\Project\\Controller' => 'HalJson',
            'ZourceProject\\V1\\Rest\\Category\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'ZourceProject\\V1\\Rest\\Project\\Controller' => array(
                0 => 'application/vnd.zource-project.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'ZourceProject\\V1\\Rest\\Category\\Controller' => array(
                0 => 'application/vnd.zource-project.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'ZourceProject\\V1\\Rest\\Project\\Controller' => array(
                0 => 'application/vnd.zource-project.v1+json',
                1 => 'application/json',
            ),
            'ZourceProject\\V1\\Rest\\Category\\Controller' => array(
                0 => 'application/vnd.zource-project.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'ZourceProject\\V1\\Rest\\Project\\ProjectEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-project.rest.project',
                'route_identifier_name' => 'project_id',
                'hydrator' => 'Zend\\Hydrator\\ClassMethods',
            ),
            'ZourceProject\\V1\\Rest\\Project\\ProjectCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-project.rest.project',
                'route_identifier_name' => 'project_id',
                'is_collection' => true,
            ),
            'ZourceProject\\V1\\Rest\\Category\\CategoryEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-project.rest.category',
                'route_identifier_name' => 'category_id',
                'hydrator' => 'Zend\\Hydrator\\ClassMethods',
            ),
            'ZourceProject\\V1\\Rest\\Category\\CategoryCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-project.rest.category',
                'route_identifier_name' => 'category_id',
                'is_collection' => true,
            ),
        ),
    ),
    'zf-content-validation' => array(
        'ZourceProject\\V1\\Rest\\Project\\Controller' => array(
            'input_filter' => 'ZourceProject\\V1\\Rest\\Project\\Validator',
        ),
        'ZourceProject\\V1\\Rest\\Category\\Controller' => array(
            'input_filter' => 'ZourceProject\\V1\\Rest\\Category\\Validator',
        ),
    ),
    'zf-mvc-auth' => array(
        'authorization' => array(
            'ZourceProject\\V1\\Rest\\Category\\Controller' => array(
                'collection' => array(
                    'GET' => true,
                    'POST' => true,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ),
                'entity' => array(
                    'GET' => true,
                    'POST' => false,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ),
            ),
            'ZourceProject\\V1\\Rest\\Project\\Controller' => array(
                'collection' => array(
                    'GET' => true,
                    'POST' => true,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ),
                'entity' => array(
                    'GET' => true,
                    'POST' => false,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ),
            ),
        ),
    ),
);
