<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

return [
    'modules' => include __DIR__ . '/modules.config.php',
    'module_listener_options' => [
        'module_paths' => [
            './module',
            './vendor'
        ],
        'config_glob_paths' => [
            realpath(__DIR__) . '/autoload/{,*.}{global,local}.php'
        ],
        'config_cache_key' => 'application.config.cache',
        'config_cache_enabled' => true,
        'module_map_cache_key' => 'application.module.cache',
        'module_map_cache_enabled' => true,
        'cache_dir' => 'data/cache/',
    ],
];
