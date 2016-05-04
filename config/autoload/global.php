<?php
return array(
    'translator' => array(
        'locale' => 'en-US',
    ),
    'zf-mvc-auth' => array(
        'authentication' => array(
            'map' => array(
                'ZourceApplication\\V1' => 'oauth2',
                'ZourceCalendar\\V1' => 'oauth2',
                'ZourceIssue\\V1' => 'oauth2',
                'ZourceProject\\V1' => 'oauth2',
                'ZourceUser\\V1' => 'oauth2',
            ),
        ),
    ),
);
