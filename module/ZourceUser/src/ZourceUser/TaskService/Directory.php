<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\TaskService;

use Zend\Config\Writer\PhpArray;
use ZourceApplication\TaskService\CacheManager;
use ZourceUser\ValueObject\Directory as DirectoryValueObject;

class Directory
{
    /**
     * @var string
     */
    private $localConfigPath;

    /**
     * @var array
     */
    private $config;

    /**
     * @var array
     */
    private $directories;

    /**
     * @var CacheManager
     */
    private $cacheManager;

    public function __construct($localConfigPath, array $config, CacheManager $cacheManager)
    {
        $this->localConfigPath = $localConfigPath;
        $this->config = $config;
        $this->cacheManager = $cacheManager;

        $this->loadDirectories();
    }

    public function getDirectories()
    {
        $directories = [];

        foreach ($this->directories as $type => $options) {
            $configOptions = $this->config[$type];

            $directory = new DirectoryValueObject(
                $type,
                $configOptions['label'],
                $options['service_name']
            );

            $directory->setEnabled($options['enabled']);

            if (array_key_exists('update_route_name', $configOptions)) {
                $directory->setUpdateRouteName($configOptions['update_route_name']);
            }

            if (array_key_exists('update_route_params', $configOptions)) {
                $directory->setUpdateRouteParams($configOptions['update_route_params']);
            }

            if (array_key_exists('update_route_options', $configOptions)) {
                $directory->setUpdateRouteOptions($configOptions['update_route_options']);
            }

            if (array_key_exists('service_name', $configOptions)) {
                $directory->setServiceName($configOptions['service_name']);
            }

            if (array_key_exists('service_options', $configOptions)) {
                $directory->setServiceOptions($configOptions['service_options']);
            }

            $directories[] = $directory;
        }

        return $directories;
    }

    public function disable($directory)
    {
        $this->directories[$directory]['enabled'] = false;

        $this->flush();
    }

    public function enable($directory)
    {
        $this->directories[$directory]['enabled'] = true;

        $this->flush();
    }

    public function moveDown($directory)
    {
        $priority = $this->directories[$directory]['priority'];

        if ($priority === count($this->directories) - 1) {
            return;
        }

        $nextPriority = $priority + 1;

        foreach ($this->directories as $type => $options) {
            if ($options['priority'] === $nextPriority) {
                $this->directories[$type]['priority'] = $priority;
                break;
            }
        }

        $this->directories[$directory]['priority'] = $nextPriority;

        $this->flush();
    }

    public function moveUp($directory)
    {
        $priority = $this->directories[$directory]['priority'];

        if ($priority === 0) {
            return;
        }

        $nextPriority = $priority - 1;

        foreach ($this->directories as $type => $options) {
            if ($options['priority'] === $nextPriority) {
                $this->directories[$type]['priority'] = $priority;
                break;
            }
        }

        $this->directories[$directory]['priority'] = $nextPriority;

        $this->flush();
    }

    private function loadDirectories()
    {
        $data = [];

        $flushRequested = true;

        if (is_file($this->localConfigPath)) {
            $data = include $this->localConfigPath;
            $flushRequested = false;
        }

        foreach ($this->config as $type => $options) {
            if (!array_key_exists($type, $data)) {
                $data[$type] = [];
            }

            if (!array_key_exists('enabled', $data[$type])) {
                $data[$type]['enabled'] = $options['enabled'];
            }

            if (!array_key_exists('priority', $data[$type])) {
                $data[$type]['priority'] = 0;
            }

            if (!array_key_exists('service_name', $data[$type])) {
                $data[$type]['service_name'] = $options['service_name'];
            }

            if (!array_key_exists('service_options', $data[$type])) {
                $data[$type]['service_options'] = $options['service_options'];
            }
        }

        uasort($data, function($lft, $rgt) {
            return strcmp($lft['priority'], $rgt['priority']);
        });

        $priority = 0;
        foreach ($data as $type => $options) {
            $data[$type]['priority'] = $priority++;
        }

        $this->directories = $data;

        if ($flushRequested) {
            $this->flush();
        }
    }

    private function flush()
    {
        $writer = new PhpArray();
        $writer->toFile($this->localConfigPath, $this->directories);

        $this->cacheManager->clearModuleCache();
    }
}
