<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\TaskService;

use Zend\Config\Writer\PhpArray;

class SettingsManager
{
    const PATH = 'config/autoload/application-settings.local.php';
    const KEY = 'zource_application_settings';

    /**
     * @var array
     */
    private $config;

    /**
     * @var CacheManager
     */
    private $cacheManager;

    /**
     * Initializes a new instance of this class.
     *
     * @param array $config
     * @param CacheManager $cacheManager
     */
    public function __construct(array $config, CacheManager $cacheManager)
    {
        $this->config = $config[self::KEY];
        $this->cacheManager = $cacheManager;
    }

    public function get($name, $defaultValue = null)
    {
        if (!array_key_exists($name, $this->config)) {
            return $defaultValue;
        }

        return $this->config[$name];
    }

    public function getAll()
    {
        return $this->config;
    }

    public function set($name, $value)
    {
        $this->config[$name] = $value;
    }

    public function flush()
    {
        $writer = new PhpArray();
        $writer->toFile(self::PATH, [
            self::KEY => $this->config
        ]);

        $this->cacheManager->clearCache('module-classmap');
        $this->cacheManager->clearCache('module-config');
    }
}
