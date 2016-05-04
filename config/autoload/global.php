<?php
return [
    'translator' => [
        'locale' => 'en-US',
    ],
    'zf-mvc-auth' => [
        'authentication' => [
            'map' => [
                'ZourceApplication\\V1' => 'oauth2',
                'ZourceCalendar\\V1' => 'oauth2',
                'ZourceIssue\\V1' => 'oauth2',
                'ZourceProject\\V1' => 'oauth2',
                'ZourceUser\\V1' => 'oauth2',
            ],
        ],
    ],
];
