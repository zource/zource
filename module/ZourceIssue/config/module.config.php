<?php
return array(
    'input_filter_specs' => array(
        'ZourceIssue\\V1\\Rest\\Component\\Validator' => array(
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
                'description' => 'The identifier of the component.',
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
                'description' => 'The name of the component.',
            ),
        ),
        'ZourceIssue\\V1\\Rest\\Field\\Validator' => array(
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
                'description' => 'The identifier of the field.',
            ),
            1 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'ZourceIssue\\Validator\\FieldType',
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
                'name' => 'type',
                'description' => 'The type of the field.',
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
                'name' => 'name',
                'description' => 'The name of the field.',
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
                'name' => 'description',
                'description' => 'The description of the field.',
                'allow_empty' => true,
            ),
        ),
        'ZourceIssue\\V1\\Rest\\FieldType\\Validator' => array(
            0 => array(
                'required' => true,
                'validators' => array(),
                'filters' => array(),
                'name' => 'id',
                'description' => 'The identifier of the field.',
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
                'description' => 'The name of the field.',
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
                'name' => 'description',
                'description' => 'The description of the field type.',
            ),
        ),
        'ZourceIssue\\V1\\Rest\\Priority\\Validator' => array(
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
                'description' => 'The identifier of the priority.',
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
                'description' => 'The name of the priority.',
            ),
            2 => array(
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
                'name' => 'description',
                'description' => 'The description of the priority.',
            ),
            3 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\I18n\\Validator\\IsInt',
                        'options' => array(),
                    ),
                ),
                'filters' => array(),
                'name' => 'position',
                'description' => 'The position of the priority.',
            ),
        ),
        'ZourceIssue\\V1\\Rest\\IssueType\\Validator' => array(
            0 => array(
                'required' => false,
                'validators' => array(),
                'filters' => array(),
                'name' => 'id',
                'description' => 'The identifier of the issue type.',
            ),
            1 => array(
                'required' => true,
                'validators' => array(),
                'filters' => array(),
                'name' => 'name',
                'description' => 'The name of the issue type.',
            ),
            2 => array(
                'required' => true,
                'validators' => array(),
                'filters' => array(),
                'name' => 'description',
                'description' => 'The description of the issue type.',
                'allow_empty' => false,
            ),
        ),
    ),
    'router' => array(
        'routes' => array(
            'zource-issue.rest.component' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/issue/component[/:component_id]',
                    'defaults' => array(
                        'controller' => 'ZourceIssue\\V1\\Rest\\Component\\Controller',
                    ),
                    'constraints' => array(
                        'component_id' => '[0-9]+',
                    ),
                ),
            ),
            'zource-issue.rest.field' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/issue/field[/:field_id]',
                    'defaults' => array(
                        'controller' => 'ZourceIssue\\V1\\Rest\\Field\\Controller',
                    ),
                    'constraints' => array(
                        'field_id' => '[0-9]+',
                    ),
                ),
            ),
            'zource-issue.rest.field-type' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/issue/field-type[/:field_type_id]',
                    'defaults' => array(
                        'controller' => 'ZourceIssue\\V1\\Rest\\FieldType\\Controller',
                    ),
                    'constraints' => array(
                        'field_type_id' => '[a-z0-9_-]+',
                    ),
                ),
            ),
            'zource-issue.rest.issue' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/issue[/:issue_id]',
                    'defaults' => array(
                        'controller' => 'ZourceIssue\\V1\\Rest\\Issue\\Controller',
                    ),
                    'constraints' => array(
                        'issue_id' => '[0-9]+',
                    ),
                ),
            ),
            'zource-issue.rest.issue-link' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/issue/issue-link[/:issue_link_id]',
                    'defaults' => array(
                        'controller' => 'ZourceIssue\\V1\\Rest\\IssueLink\\Controller',
                    ),
                    'constraints' => array(
                        'issue_link_id' => '[0-9]+',
                    ),
                ),
            ),
            'zource-issue.rest.issue-type' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/issue/type[/:issue_type_id]',
                    'defaults' => array(
                        'controller' => 'ZourceIssue\\V1\\Rest\\IssueType\\Controller',
                    ),
                    'constraints' => array(
                        'issue_type_id' => '[0-9]+',
                    ),
                ),
            ),
            'zource-issue.rest.priority' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/issue/priority[/:priority_id]',
                    'defaults' => array(
                        'controller' => 'ZourceIssue\\V1\\Rest\\Priority\\Controller',
                    ),
                    'constraints' => array(
                        'priority_id' => '[0-9]+',
                    ),
                ),
            ),
            'zource-issue.rest.resolution' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/issue/resolution[/:resolution_id]',
                    'defaults' => array(
                        'controller' => 'ZourceIssue\\V1\\Rest\\Resolution\\Controller',
                    ),
                    'constraints' => array(
                        'resolution_id' => '[0-9]+',
                    ),
                ),
            ),
            'zource-issue.rest.screen' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/issue/screen[/:screen_id]',
                    'defaults' => array(
                        'controller' => 'ZourceIssue\\V1\\Rest\\Screen\\Controller',
                    ),
                    'constraints' => array(
                        'screen_id' => '[0-9]+',
                    ),
                ),
            ),
            'zource-issue.rest.screen-scheme' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/issue/screen-scheme[/:screen_scheme_id]',
                    'defaults' => array(
                        'controller' => 'ZourceIssue\\V1\\Rest\\ScreenScheme\\Controller',
                    ),
                    'constraints' => array(
                        'screen_scheme_id' => '[0-9]+',
                    ),
                ),
            ),
            'zource-issue.rest.status' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/issue/status[/:status_id]',
                    'defaults' => array(
                        'controller' => 'ZourceIssue\\V1\\Rest\\Status\\Controller',
                    ),
                    'constraints' => array(
                        'status_id' => '[0-9]+',
                    ),
                ),
            ),
            'zource-issue.rest.transition' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/issue/transition[/:transition_id]',
                    'defaults' => array(
                        'controller' => 'ZourceIssue\\V1\\Rest\\Transition\\Controller',
                    ),
                    'constraints' => array(
                        'transition_id' => '[0-9]+',
                    ),
                ),
            ),
            'zource-issue.rest.version' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/issue/version[/:version_id]',
                    'defaults' => array(
                        'controller' => 'ZourceIssue\\V1\\Rest\\Version\\Controller',
                    ),
                    'constraints' => array(
                        'version_id' => '[0-9]+',
                    ),
                ),
            ),
            'zource-issue.rest.workflow' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/issue/workflow[/:workflow_id]',
                    'defaults' => array(
                        'controller' => 'ZourceIssue\\V1\\Rest\\Workflow\\Controller',
                    ),
                    'constraints' => array(
                        'workflow_id' => '[0-9]+',
                    ),
                ),
            ),
            'zource-issue.rest.workflow-scheme' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/issue/workflow-scheme[/:workflow_scheme_id]',
                    'defaults' => array(
                        'controller' => 'ZourceIssue\\V1\\Rest\\WorkflowScheme\\Controller',
                    ),
                    'constraints' => array(
                        'workflow_scheme_id' => '[0-9]+',
                    ),
                ),
            ),
            'zource-issue.rest.worklog' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/issue/worklog[/:worklog_id]',
                    'defaults' => array(
                        'controller' => 'ZourceIssue\\V1\\Rest\\Worklog\\Controller',
                    ),
                    'constraints' => array(
                        'worklog_id' => '[0-9]+',
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'ZourceIssue\\V1\\Rest\\Component\\ComponentResource' => 'ZourceIssue\\V1\\Rest\\Component\\ComponentResourceFactory',
            'ZourceIssue\\V1\\Rest\\Field\\FieldResource' => 'ZourceIssue\\V1\\Rest\\Field\\FieldResourceFactory',
            'ZourceIssue\\V1\\Rest\\FieldType\\FieldTypeResource' => 'ZourceIssue\\V1\\Rest\\FieldType\\FieldTypeResourceFactory',
            'ZourceIssue\\V1\\Rest\\Issue\\IssueResource' => 'ZourceIssue\\V1\\Rest\\Issue\\IssueResourceFactory',
            'ZourceIssue\\V1\\Rest\\IssueLink\\IssueLinkResource' => 'ZourceIssue\\V1\\Rest\\IssueLink\\IssueLinkResourceFactory',
            'ZourceIssue\\V1\\Rest\\IssueType\\IssueTypeResource' => 'ZourceIssue\\V1\\Rest\\IssueType\\IssueTypeResourceFactory',
            'ZourceIssue\\V1\\Rest\\Priority\\PriorityResource' => 'ZourceIssue\\V1\\Rest\\Priority\\PriorityResourceFactory',
            'ZourceIssue\\V1\\Rest\\Resolution\\ResolutionResource' => 'ZourceIssue\\V1\\Rest\\Resolution\\ResolutionResourceFactory',
            'ZourceIssue\\V1\\Rest\\Screen\\ScreenResource' => 'ZourceIssue\\V1\\Rest\\Screen\\ScreenResourceFactory',
            'ZourceIssue\\V1\\Rest\\ScreenScheme\\ScreenSchemeResource' => 'ZourceIssue\\V1\\Rest\\ScreenScheme\\ScreenSchemeResourceFactory',
            'ZourceIssue\\V1\\Rest\\Status\\StatusResource' => 'ZourceIssue\\V1\\Rest\\Status\\StatusResourceFactory',
            'ZourceIssue\\V1\\Rest\\Transition\\TransitionResource' => 'ZourceIssue\\V1\\Rest\\Transition\\TransitionResourceFactory',
            'ZourceIssue\\V1\\Rest\\Version\\VersionResource' => 'ZourceIssue\\V1\\Rest\\Version\\VersionResourceFactory',
            'ZourceIssue\\V1\\Rest\\Workflow\\WorkflowResource' => 'ZourceIssue\\V1\\Rest\\Workflow\\WorkflowResourceFactory',
            'ZourceIssue\\V1\\Rest\\WorkflowScheme\\WorkflowSchemeResource' => 'ZourceIssue\\V1\\Rest\\WorkflowScheme\\WorkflowSchemeResourceFactory',
            'ZourceIssue\\V1\\Rest\\Worklog\\WorklogResource' => 'ZourceIssue\\V1\\Rest\\Worklog\\WorklogResourceFactory',
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'zource-issue.rest.component',
            1 => 'zource-issue.rest.field',
            2 => 'zource-issue.rest.field-type',
            3 => 'zource-issue.rest.issue',
            4 => 'zource-issue.rest.issue-link',
            5 => 'zource-issue.rest.issue-type',
            6 => 'zource-issue.rest.priority',
            7 => 'zource-issue.rest.resolution',
            8 => 'zource-issue.rest.screen',
            9 => 'zource-issue.rest.screen-scheme',
            10 => 'zource-issue.rest.status',
            11 => 'zource-issue.rest.transition',
            12 => 'zource-issue.rest.version',
            13 => 'zource-issue.rest.workflow',
            14 => 'zource-issue.rest.workflow-scheme',
            15 => 'zource-issue.rest.worklog',
        ),
    ),
    'zf-rest' => array(
        'ZourceIssue\\V1\\Rest\\Component\\Controller' => array(
            'listener' => 'ZourceIssue\\V1\\Rest\\Component\\ComponentResource',
            'route_name' => 'zource-issue.rest.component',
            'route_identifier_name' => 'component_id',
            'collection_name' => 'component',
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
            'entity_class' => 'ZourceIssue\\V1\\Rest\\Component\\ComponentEntity',
            'collection_class' => 'ZourceIssue\\V1\\Rest\\Component\\ComponentCollection',
            'service_name' => 'Component',
        ),
        'ZourceIssue\\V1\\Rest\\Field\\Controller' => array(
            'listener' => 'ZourceIssue\\V1\\Rest\\Field\\FieldResource',
            'route_name' => 'zource-issue.rest.field',
            'route_identifier_name' => 'field_id',
            'collection_name' => 'field',
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
            'entity_class' => 'ZourceIssue\\V1\\Rest\\Field\\FieldEntity',
            'collection_class' => 'ZourceIssue\\V1\\Rest\\Field\\FieldCollection',
            'service_name' => 'Field',
        ),
        'ZourceIssue\\V1\\Rest\\FieldType\\Controller' => array(
            'listener' => 'ZourceIssue\\V1\\Rest\\FieldType\\FieldTypeResource',
            'route_name' => 'zource-issue.rest.field-type',
            'route_identifier_name' => 'field_type_id',
            'collection_name' => 'field_type',
            'entity_http_methods' => array(
                0 => 'GET',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'ZourceIssue\\V1\\Rest\\FieldType\\FieldTypeEntity',
            'collection_class' => 'ZourceIssue\\V1\\Rest\\FieldType\\FieldTypeCollection',
            'service_name' => 'FieldType',
        ),
        'ZourceIssue\\V1\\Rest\\Issue\\Controller' => array(
            'listener' => 'ZourceIssue\\V1\\Rest\\Issue\\IssueResource',
            'route_name' => 'zource-issue.rest.issue',
            'route_identifier_name' => 'issue_id',
            'collection_name' => 'issue',
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
            'entity_class' => 'ZourceIssue\\V1\\Rest\\Issue\\IssueEntity',
            'collection_class' => 'ZourceIssue\\V1\\Rest\\Issue\\IssueCollection',
            'service_name' => 'Issue',
        ),
        'ZourceIssue\\V1\\Rest\\IssueLink\\Controller' => array(
            'listener' => 'ZourceIssue\\V1\\Rest\\IssueLink\\IssueLinkResource',
            'route_name' => 'zource-issue.rest.issue-link',
            'route_identifier_name' => 'issue_link_id',
            'collection_name' => 'issue_link',
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
            'entity_class' => 'ZourceIssue\\V1\\Rest\\IssueLink\\IssueLinkEntity',
            'collection_class' => 'ZourceIssue\\V1\\Rest\\IssueLink\\IssueLinkCollection',
            'service_name' => 'IssueLink',
        ),
        'ZourceIssue\\V1\\Rest\\IssueType\\Controller' => array(
            'listener' => 'ZourceIssue\\V1\\Rest\\IssueType\\IssueTypeResource',
            'route_name' => 'zource-issue.rest.issue-type',
            'route_identifier_name' => 'issue_type_id',
            'collection_name' => 'issue_type',
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
            'entity_class' => 'ZourceIssue\\V1\\Rest\\IssueType\\IssueTypeEntity',
            'collection_class' => 'ZourceIssue\\V1\\Rest\\IssueType\\IssueTypeCollection',
            'service_name' => 'IssueType',
        ),
        'ZourceIssue\\V1\\Rest\\Priority\\Controller' => array(
            'listener' => 'ZourceIssue\\V1\\Rest\\Priority\\PriorityResource',
            'route_name' => 'zource-issue.rest.priority',
            'route_identifier_name' => 'priority_id',
            'collection_name' => 'priority',
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
            'entity_class' => 'ZourceIssue\\V1\\Rest\\Priority\\PriorityEntity',
            'collection_class' => 'ZourceIssue\\V1\\Rest\\Priority\\PriorityCollection',
            'service_name' => 'Priority',
        ),
        'ZourceIssue\\V1\\Rest\\Resolution\\Controller' => array(
            'listener' => 'ZourceIssue\\V1\\Rest\\Resolution\\ResolutionResource',
            'route_name' => 'zource-issue.rest.resolution',
            'route_identifier_name' => 'resolution_id',
            'collection_name' => 'resolution',
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
            'entity_class' => 'ZourceIssue\\V1\\Rest\\Resolution\\ResolutionEntity',
            'collection_class' => 'ZourceIssue\\V1\\Rest\\Resolution\\ResolutionCollection',
            'service_name' => 'Resolution',
        ),
        'ZourceIssue\\V1\\Rest\\Screen\\Controller' => array(
            'listener' => 'ZourceIssue\\V1\\Rest\\Screen\\ScreenResource',
            'route_name' => 'zource-issue.rest.screen',
            'route_identifier_name' => 'screen_id',
            'collection_name' => 'screen',
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
            'entity_class' => 'ZourceIssue\\V1\\Rest\\Screen\\ScreenEntity',
            'collection_class' => 'ZourceIssue\\V1\\Rest\\Screen\\ScreenCollection',
            'service_name' => 'Screen',
        ),
        'ZourceIssue\\V1\\Rest\\ScreenScheme\\Controller' => array(
            'listener' => 'ZourceIssue\\V1\\Rest\\ScreenScheme\\ScreenSchemeResource',
            'route_name' => 'zource-issue.rest.screen-scheme',
            'route_identifier_name' => 'screen_scheme_id',
            'collection_name' => 'screen_scheme',
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
            'entity_class' => 'ZourceIssue\\V1\\Rest\\ScreenScheme\\ScreenSchemeEntity',
            'collection_class' => 'ZourceIssue\\V1\\Rest\\ScreenScheme\\ScreenSchemeCollection',
            'service_name' => 'ScreenScheme',
        ),
        'ZourceIssue\\V1\\Rest\\Status\\Controller' => array(
            'listener' => 'ZourceIssue\\V1\\Rest\\Status\\StatusResource',
            'route_name' => 'zource-issue.rest.status',
            'route_identifier_name' => 'status_id',
            'collection_name' => 'status',
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
            'entity_class' => 'ZourceIssue\\V1\\Rest\\Status\\StatusEntity',
            'collection_class' => 'ZourceIssue\\V1\\Rest\\Status\\StatusCollection',
            'service_name' => 'Status',
        ),
        'ZourceIssue\\V1\\Rest\\Transition\\Controller' => array(
            'listener' => 'ZourceIssue\\V1\\Rest\\Transition\\TransitionResource',
            'route_name' => 'zource-issue.rest.transition',
            'route_identifier_name' => 'transition_id',
            'collection_name' => 'transition',
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
            'entity_class' => 'ZourceIssue\\V1\\Rest\\Transition\\TransitionEntity',
            'collection_class' => 'ZourceIssue\\V1\\Rest\\Transition\\TransitionCollection',
            'service_name' => 'Transition',
        ),
        'ZourceIssue\\V1\\Rest\\Version\\Controller' => array(
            'listener' => 'ZourceIssue\\V1\\Rest\\Version\\VersionResource',
            'route_name' => 'zource-issue.rest.version',
            'route_identifier_name' => 'version_id',
            'collection_name' => 'version',
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
            'entity_class' => 'ZourceIssue\\V1\\Rest\\Version\\VersionEntity',
            'collection_class' => 'ZourceIssue\\V1\\Rest\\Version\\VersionCollection',
            'service_name' => 'Version',
        ),
        'ZourceIssue\\V1\\Rest\\Workflow\\Controller' => array(
            'listener' => 'ZourceIssue\\V1\\Rest\\Workflow\\WorkflowResource',
            'route_name' => 'zource-issue.rest.workflow',
            'route_identifier_name' => 'workflow_id',
            'collection_name' => 'workflow',
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
            'entity_class' => 'ZourceIssue\\V1\\Rest\\Workflow\\WorkflowEntity',
            'collection_class' => 'ZourceIssue\\V1\\Rest\\Workflow\\WorkflowCollection',
            'service_name' => 'Workflow',
        ),
        'ZourceIssue\\V1\\Rest\\WorkflowScheme\\Controller' => array(
            'listener' => 'ZourceIssue\\V1\\Rest\\WorkflowScheme\\WorkflowSchemeResource',
            'route_name' => 'zource-issue.rest.workflow-scheme',
            'route_identifier_name' => 'workflow_scheme_id',
            'collection_name' => 'workflow_scheme',
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
            'entity_class' => 'ZourceIssue\\V1\\Rest\\WorkflowScheme\\WorkflowSchemeEntity',
            'collection_class' => 'ZourceIssue\\V1\\Rest\\WorkflowScheme\\WorkflowSchemeCollection',
            'service_name' => 'WorkflowScheme',
        ),
        'ZourceIssue\\V1\\Rest\\Worklog\\Controller' => array(
            'listener' => 'ZourceIssue\\V1\\Rest\\Worklog\\WorklogResource',
            'route_name' => 'zource-issue.rest.worklog',
            'route_identifier_name' => 'worklog_id',
            'collection_name' => 'worklog',
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
            'entity_class' => 'ZourceIssue\\V1\\Rest\\Worklog\\WorklogEntity',
            'collection_class' => 'ZourceIssue\\V1\\Rest\\Worklog\\WorklogCollection',
            'service_name' => 'Worklog',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'ZourceIssue\\V1\\Rest\\Component\\Controller' => 'HalJson',
            'ZourceIssue\\V1\\Rest\\Field\\Controller' => 'HalJson',
            'ZourceIssue\\V1\\Rest\\FieldType\\Controller' => 'HalJson',
            'ZourceIssue\\V1\\Rest\\Issue\\Controller' => 'HalJson',
            'ZourceIssue\\V1\\Rest\\IssueLink\\Controller' => 'HalJson',
            'ZourceIssue\\V1\\Rest\\IssueType\\Controller' => 'HalJson',
            'ZourceIssue\\V1\\Rest\\Priority\\Controller' => 'HalJson',
            'ZourceIssue\\V1\\Rest\\Resolution\\Controller' => 'HalJson',
            'ZourceIssue\\V1\\Rest\\Screen\\Controller' => 'HalJson',
            'ZourceIssue\\V1\\Rest\\ScreenScheme\\Controller' => 'HalJson',
            'ZourceIssue\\V1\\Rest\\Status\\Controller' => 'HalJson',
            'ZourceIssue\\V1\\Rest\\Transition\\Controller' => 'HalJson',
            'ZourceIssue\\V1\\Rest\\Version\\Controller' => 'HalJson',
            'ZourceIssue\\V1\\Rest\\Workflow\\Controller' => 'HalJson',
            'ZourceIssue\\V1\\Rest\\WorkflowScheme\\Controller' => 'HalJson',
            'ZourceIssue\\V1\\Rest\\Worklog\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'ZourceIssue\\V1\\Rest\\Component\\Controller' => array(
                0 => 'application/vnd.zource-issue.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'ZourceIssue\\V1\\Rest\\Field\\Controller' => array(
                0 => 'application/vnd.zource-issue.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'ZourceIssue\\V1\\Rest\\FieldType\\Controller' => array(
                0 => 'application/vnd.zource-issue.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'ZourceIssue\\V1\\Rest\\Issue\\Controller' => array(
                0 => 'application/vnd.zource-issue.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'ZourceIssue\\V1\\Rest\\IssueLink\\Controller' => array(
                0 => 'application/vnd.zource-issue.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'ZourceIssue\\V1\\Rest\\IssueType\\Controller' => array(
                0 => 'application/vnd.zource-issue.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'ZourceIssue\\V1\\Rest\\Priority\\Controller' => array(
                0 => 'application/vnd.zource-issue.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'ZourceIssue\\V1\\Rest\\Resolution\\Controller' => array(
                0 => 'application/vnd.zource-issue.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'ZourceIssue\\V1\\Rest\\Screen\\Controller' => array(
                0 => 'application/vnd.zource-issue.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'ZourceIssue\\V1\\Rest\\ScreenScheme\\Controller' => array(
                0 => 'application/vnd.zource-issue.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'ZourceIssue\\V1\\Rest\\Status\\Controller' => array(
                0 => 'application/vnd.zource-issue.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'ZourceIssue\\V1\\Rest\\Transition\\Controller' => array(
                0 => 'application/vnd.zource-issue.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'ZourceIssue\\V1\\Rest\\Version\\Controller' => array(
                0 => 'application/vnd.zource-issue.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'ZourceIssue\\V1\\Rest\\Workflow\\Controller' => array(
                0 => 'application/vnd.zource-issue.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'ZourceIssue\\V1\\Rest\\WorkflowScheme\\Controller' => array(
                0 => 'application/vnd.zource-issue.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'ZourceIssue\\V1\\Rest\\Worklog\\Controller' => array(
                0 => 'application/vnd.zource-issue.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'ZourceIssue\\V1\\Rest\\Component\\Controller' => array(
                0 => 'application/vnd.zource-issue.v1+json',
                1 => 'application/json',
            ),
            'ZourceIssue\\V1\\Rest\\Field\\Controller' => array(
                0 => 'application/vnd.zource-issue.v1+json',
                1 => 'application/json',
            ),
            'ZourceIssue\\V1\\Rest\\FieldType\\Controller' => array(
                0 => 'application/vnd.zource-issue.v1+json',
                1 => 'application/json',
            ),
            'ZourceIssue\\V1\\Rest\\Issue\\Controller' => array(
                0 => 'application/vnd.zource-issue.v1+json',
                1 => 'application/json',
            ),
            'ZourceIssue\\V1\\Rest\\IssueLink\\Controller' => array(
                0 => 'application/vnd.zource-issue.v1+json',
                1 => 'application/json',
            ),
            'ZourceIssue\\V1\\Rest\\IssueType\\Controller' => array(
                0 => 'application/vnd.zource-issue.v1+json',
                1 => 'application/json',
            ),
            'ZourceIssue\\V1\\Rest\\Priority\\Controller' => array(
                0 => 'application/vnd.zource-issue.v1+json',
                1 => 'application/json',
            ),
            'ZourceIssue\\V1\\Rest\\Resolution\\Controller' => array(
                0 => 'application/vnd.zource-issue.v1+json',
                1 => 'application/json',
            ),
            'ZourceIssue\\V1\\Rest\\Screen\\Controller' => array(
                0 => 'application/vnd.zource-issue.v1+json',
                1 => 'application/json',
            ),
            'ZourceIssue\\V1\\Rest\\ScreenScheme\\Controller' => array(
                0 => 'application/vnd.zource-issue.v1+json',
                1 => 'application/json',
            ),
            'ZourceIssue\\V1\\Rest\\Status\\Controller' => array(
                0 => 'application/vnd.zource-issue.v1+json',
                1 => 'application/json',
            ),
            'ZourceIssue\\V1\\Rest\\Transition\\Controller' => array(
                0 => 'application/vnd.zource-issue.v1+json',
                1 => 'application/json',
            ),
            'ZourceIssue\\V1\\Rest\\Version\\Controller' => array(
                0 => 'application/vnd.zource-issue.v1+json',
                1 => 'application/json',
            ),
            'ZourceIssue\\V1\\Rest\\Workflow\\Controller' => array(
                0 => 'application/vnd.zource-issue.v1+json',
                1 => 'application/json',
            ),
            'ZourceIssue\\V1\\Rest\\WorkflowScheme\\Controller' => array(
                0 => 'application/vnd.zource-issue.v1+json',
                1 => 'application/json',
            ),
            'ZourceIssue\\V1\\Rest\\Worklog\\Controller' => array(
                0 => 'application/vnd.zource-issue.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'ZourceIssue\\V1\\Rest\\Component\\ComponentEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-issue.rest.component',
                'route_identifier_name' => 'component_id',
                'hydrator' => 'Zend\\Hydrator\\ClassMethods',
            ),
            'ZourceIssue\\V1\\Rest\\Component\\ComponentCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-issue.rest.component',
                'route_identifier_name' => 'component_id',
                'is_collection' => true,
            ),
            'ZourceIssue\\V1\\Rest\\Field\\FieldEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-issue.rest.field',
                'route_identifier_name' => 'field_id',
                'hydrator' => 'Zend\\Hydrator\\ClassMethods',
            ),
            'ZourceIssue\\V1\\Rest\\Field\\FieldCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-issue.rest.field',
                'route_identifier_name' => 'field_id',
                'is_collection' => true,
            ),
            'ZourceIssue\\V1\\Rest\\FieldType\\FieldTypeEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-issue.rest.field-type',
                'route_identifier_name' => 'field_type_id',
                'hydrator' => 'Zend\\Hydrator\\ClassMethods',
            ),
            'ZourceIssue\\V1\\Rest\\FieldType\\FieldTypeCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-issue.rest.field-type',
                'route_identifier_name' => 'field_type_id',
                'is_collection' => true,
            ),
            'ZourceIssue\\V1\\Rest\\Issue\\IssueEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-issue.rest.issue',
                'route_identifier_name' => 'issue_id',
                'hydrator' => 'Zend\\Hydrator\\ClassMethods',
            ),
            'ZourceIssue\\V1\\Rest\\Issue\\IssueCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-issue.rest.issue',
                'route_identifier_name' => 'issue_id',
                'is_collection' => true,
            ),
            'ZourceIssue\\V1\\Rest\\IssueLink\\IssueLinkEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-issue.rest.issue-link',
                'route_identifier_name' => 'issue_link_id',
                'hydrator' => 'Zend\\Hydrator\\ClassMethods',
            ),
            'ZourceIssue\\V1\\Rest\\IssueLink\\IssueLinkCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-issue.rest.issue-link',
                'route_identifier_name' => 'issue_link_id',
                'is_collection' => true,
            ),
            'ZourceIssue\\V1\\Rest\\IssueType\\IssueTypeEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-issue.rest.issue-type',
                'route_identifier_name' => 'issue_type_id',
                'hydrator' => 'Zend\\Hydrator\\ClassMethods',
            ),
            'ZourceIssue\\V1\\Rest\\IssueType\\IssueTypeCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-issue.rest.issue-type',
                'route_identifier_name' => 'issue_type_id',
                'is_collection' => true,
            ),
            'ZourceIssue\\V1\\Rest\\Priority\\PriorityEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-issue.rest.priority',
                'route_identifier_name' => 'priority_id',
                'hydrator' => 'Zend\\Hydrator\\ClassMethods',
            ),
            'ZourceIssue\\V1\\Rest\\Priority\\PriorityCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-issue.rest.priority',
                'route_identifier_name' => 'priority_id',
                'is_collection' => true,
            ),
            'ZourceIssue\\V1\\Rest\\Resolution\\ResolutionEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-issue.rest.resolution',
                'route_identifier_name' => 'resolution_id',
                'hydrator' => 'Zend\\Hydrator\\ClassMethods',
            ),
            'ZourceIssue\\V1\\Rest\\Resolution\\ResolutionCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-issue.rest.resolution',
                'route_identifier_name' => 'resolution_id',
                'is_collection' => true,
            ),
            'ZourceIssue\\V1\\Rest\\Screen\\ScreenEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-issue.rest.screen',
                'route_identifier_name' => 'screen_id',
                'hydrator' => 'Zend\\Hydrator\\ClassMethods',
            ),
            'ZourceIssue\\V1\\Rest\\Screen\\ScreenCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-issue.rest.screen',
                'route_identifier_name' => 'screen_id',
                'is_collection' => true,
            ),
            'ZourceIssue\\V1\\Rest\\ScreenScheme\\ScreenSchemeEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-issue.rest.screen-scheme',
                'route_identifier_name' => 'screen_scheme_id',
                'hydrator' => 'Zend\\Hydrator\\ClassMethods',
            ),
            'ZourceIssue\\V1\\Rest\\ScreenScheme\\ScreenSchemeCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-issue.rest.screen-scheme',
                'route_identifier_name' => 'screen_scheme_id',
                'is_collection' => true,
            ),
            'ZourceIssue\\V1\\Rest\\Status\\StatusEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-issue.rest.status',
                'route_identifier_name' => 'status_id',
                'hydrator' => 'Zend\\Hydrator\\ClassMethods',
            ),
            'ZourceIssue\\V1\\Rest\\Status\\StatusCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-issue.rest.status',
                'route_identifier_name' => 'status_id',
                'is_collection' => true,
            ),
            'ZourceIssue\\V1\\Rest\\Transition\\TransitionEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-issue.rest.transition',
                'route_identifier_name' => 'transition_id',
                'hydrator' => 'Zend\\Hydrator\\ClassMethods',
            ),
            'ZourceIssue\\V1\\Rest\\Transition\\TransitionCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-issue.rest.transition',
                'route_identifier_name' => 'transition_id',
                'is_collection' => true,
            ),
            'ZourceIssue\\V1\\Rest\\Version\\VersionEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-issue.rest.version',
                'route_identifier_name' => 'version_id',
                'hydrator' => 'Zend\\Hydrator\\ClassMethods',
            ),
            'ZourceIssue\\V1\\Rest\\Version\\VersionCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-issue.rest.version',
                'route_identifier_name' => 'version_id',
                'is_collection' => true,
            ),
            'ZourceIssue\\V1\\Rest\\Workflow\\WorkflowEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-issue.rest.workflow',
                'route_identifier_name' => 'workflow_id',
                'hydrator' => 'Zend\\Hydrator\\ClassMethods',
            ),
            'ZourceIssue\\V1\\Rest\\Workflow\\WorkflowCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-issue.rest.workflow',
                'route_identifier_name' => 'workflow_id',
                'is_collection' => true,
            ),
            'ZourceIssue\\V1\\Rest\\WorkflowScheme\\WorkflowSchemeEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-issue.rest.workflow-scheme',
                'route_identifier_name' => 'workflow_scheme_id',
                'hydrator' => 'Zend\\Hydrator\\ClassMethods',
            ),
            'ZourceIssue\\V1\\Rest\\WorkflowScheme\\WorkflowSchemeCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-issue.rest.workflow-scheme',
                'route_identifier_name' => 'workflow_scheme_id',
                'is_collection' => true,
            ),
            'ZourceIssue\\V1\\Rest\\Worklog\\WorklogEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-issue.rest.worklog',
                'route_identifier_name' => 'worklog_id',
                'hydrator' => 'Zend\\Hydrator\\ClassMethods',
            ),
            'ZourceIssue\\V1\\Rest\\Worklog\\WorklogCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-issue.rest.worklog',
                'route_identifier_name' => 'worklog_id',
                'is_collection' => true,
            ),
        ),
    ),
    'zf-content-validation' => array(
        'ZourceIssue\\V1\\Rest\\Component\\Controller' => array(
            'input_filter' => 'ZourceIssue\\V1\\Rest\\Component\\Validator',
        ),
        'ZourceIssue\\V1\\Rest\\FieldType\\Controller' => array(
            'input_filter' => 'ZourceIssue\\V1\\Rest\\FieldType\\Validator',
        ),
        'ZourceIssue\\V1\\Rest\\Field\\Controller' => array(
            'input_filter' => 'ZourceIssue\\V1\\Rest\\Field\\Validator',
        ),
        'ZourceIssue\\V1\\Rest\\Priority\\Controller' => array(
            'input_filter' => 'ZourceIssue\\V1\\Rest\\Priority\\Validator',
        ),
        'ZourceIssue\\V1\\Rest\\IssueType\\Controller' => array(
            'input_filter' => 'ZourceIssue\\V1\\Rest\\IssueType\\Validator',
        ),
    ),
    'zf-mvc-auth' => array(
        'authorization' => array(
            'ZourceIssue\\V1\\Rest\\Component\\Controller' => array(
                'collection' => array(
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
                'entity' => array(
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
            ),
            'ZourceIssue\\V1\\Rest\\Field\\Controller' => array(
                'collection' => array(
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
                'entity' => array(
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
            ),
            'ZourceIssue\\V1\\Rest\\FieldType\\Controller' => array(
                'collection' => array(
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
                'entity' => array(
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
            ),
            'ZourceIssue\\V1\\Rest\\Issue\\Controller' => array(
                'collection' => array(
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
                'entity' => array(
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
            ),
            'ZourceIssue\\V1\\Rest\\IssueLink\\Controller' => array(
                'collection' => array(
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
                'entity' => array(
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
            ),
            'ZourceIssue\\V1\\Rest\\IssueType\\Controller' => array(
                'collection' => array(
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
                'entity' => array(
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
            ),
            'ZourceIssue\\V1\\Rest\\Priority\\Controller' => array(
                'collection' => array(
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
                'entity' => array(
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
            ),
        ),
    ),
);
