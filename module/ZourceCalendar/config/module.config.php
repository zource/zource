<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

return array(
    'service_manager' => array(
        'factories' => array(
            'ZourceCalendar\\V1\\Rest\\Calendar\\CalendarResource' => 'ZourceCalendar\\V1\\Rest\\Calendar\\CalendarResourceFactory',
            'ZourceCalendar\\V1\\Rest\\Event\\EventResource' => 'ZourceCalendar\\V1\\Rest\\Event\\EventResourceFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'zource-calendar.rest.calendar' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/calendar[/:calendar_id]',
                    'defaults' => array(
                        'controller' => 'ZourceCalendar\\V1\\Rest\\Calendar\\Controller',
                    ),
                    'constraints' => array(
                        'calendar_id' => '[0-9]+',
                    ),
                ),
            ),
            'zource-calendar.rest.event' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/calendar/event[/:event_id]',
                    'defaults' => array(
                        'controller' => 'ZourceCalendar\\V1\\Rest\\Event\\Controller',
                    ),
                    'constraints' => array(
                        'event_id' => '[0-9]+',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'zource-calendar.rest.calendar',
            1 => 'zource-calendar.rest.event',
        ),
    ),
    'zf-rest' => array(
        'ZourceCalendar\\V1\\Rest\\Calendar\\Controller' => array(
            'listener' => 'ZourceCalendar\\V1\\Rest\\Calendar\\CalendarResource',
            'route_name' => 'zource-calendar.rest.calendar',
            'route_identifier_name' => 'calendar_id',
            'collection_name' => 'calendar',
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
            'entity_class' => 'ZourceCalendar\\V1\\Rest\\Calendar\\CalendarEntity',
            'collection_class' => 'ZourceCalendar\\V1\\Rest\\Calendar\\CalendarCollection',
            'service_name' => 'Calendar',
        ),
        'ZourceCalendar\\V1\\Rest\\Event\\Controller' => array(
            'listener' => 'ZourceCalendar\\V1\\Rest\\Event\\EventResource',
            'route_name' => 'zource-calendar.rest.event',
            'route_identifier_name' => 'event_id',
            'collection_name' => 'event',
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
            'entity_class' => 'ZourceCalendar\\V1\\Rest\\Event\\EventEntity',
            'collection_class' => 'ZourceCalendar\\V1\\Rest\\Event\\EventCollection',
            'service_name' => 'Event',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'ZourceCalendar\\V1\\Rest\\Calendar\\Controller' => 'HalJson',
            'ZourceCalendar\\V1\\Rest\\Event\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'ZourceCalendar\\V1\\Rest\\Calendar\\Controller' => array(
                0 => 'application/vnd.zource-calendar.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'ZourceCalendar\\V1\\Rest\\Event\\Controller' => array(
                0 => 'application/vnd.zource-calendar.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'ZourceCalendar\\V1\\Rest\\Calendar\\Controller' => array(
                0 => 'application/vnd.zource-calendar.v1+json',
                1 => 'application/json',
            ),
            'ZourceCalendar\\V1\\Rest\\Event\\Controller' => array(
                0 => 'application/vnd.zource-calendar.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'ZourceCalendar\\V1\\Rest\\Calendar\\CalendarEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-calendar.rest.calendar',
                'route_identifier_name' => 'calendar_id',
                'hydrator' => 'Zend\\Hydrator\\ArraySerializable',
            ),
            'ZourceCalendar\\V1\\Rest\\Calendar\\CalendarCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-calendar.rest.calendar',
                'route_identifier_name' => 'calendar_id',
                'is_collection' => true,
            ),
            'ZourceCalendar\\V1\\Rest\\Event\\EventEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-calendar.rest.event',
                'route_identifier_name' => 'event_id',
                'hydrator' => 'Zend\\Hydrator\\ArraySerializable',
            ),
            'ZourceCalendar\\V1\\Rest\\Event\\EventCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'zource-calendar.rest.event',
                'route_identifier_name' => 'event_id',
                'is_collection' => true,
            ),
        ),
    ),
    'zf-mvc-auth' => array(
        'authorization' => array(
            'ZourceCalendar\\V1\\Rest\\Calendar\\Controller' => array(
                'collection' => array(
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
                'entity' => array(
                    'GET' => true,
                    'POST' => false,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ),
            ),
            'ZourceCalendar\\V1\\Rest\\Event\\Controller' => array(
                'collection' => array(
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
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
