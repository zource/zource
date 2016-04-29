<?php
return array(
    'router' => array(
        'routes' => array(
            'oauth2' => array(
                'options' => array(
                    'spec' => '%oauth%',
                    'regex' => '(?P<oauth>(/authenticate/oauth))',
                ),
                'type' => 'regex',
            ),
        ),
    ),
    'zf-mvc-auth' => array(
        'authentication' => array(
            'map' => array(),
        ),
    ),
);
