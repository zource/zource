<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceIssue;

return [
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ => [
                'class' => 'Doctrine\\ORM\\Mapping\\Driver\\AnnotationDriver',
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/V1/Rest/Component',
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/V1/Rest/Field',
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/V1/Rest/FieldType',
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/V1/Rest/Issue',
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/V1/Rest/IssueLink',
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/V1/Rest/IssueType',
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/V1/Rest/Priority',
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/V1/Rest/Resolution',
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/V1/Rest/Screen',
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/V1/Rest/ScreenScheme',
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/V1/Rest/Status',
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/V1/Rest/Transition',
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/V1/Rest/Version',
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/V1/Rest/Workflow',
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/V1/Rest/WorkflowScheme',
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/V1/Rest/Worklog',
                ],
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ => __NAMESPACE__,
                ],
            ],
        ],
    ],
    'validators' => [
        'factories' => [
            'ZourceIssue\\Validator\\FieldType' => 'ZourceIssue\\Validator\\Service\\FieldTypeFactory',
        ],
    ],
    'zource' => [
        'field-type' => [
            [
                'id' => 'date',
                'name' => 'Date',
                'description' => 'The representation of a date.'
            ],
            [
                'id' => 'datetime',
                'name' => 'Datetime',
                'description' => 'The representation of a date and a time.'
            ],
            [
                'id' => 'numeric',
                'name' => 'Numeric',
                'description' => 'The representation of a numeric value.'
            ],
            [
                'id' => 'text',
                'name' => 'Text',
                'description' => 'The representation of a textual value.'
            ],
        ],
    ],
];
