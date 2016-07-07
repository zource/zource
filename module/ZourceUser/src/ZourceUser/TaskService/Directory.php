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
    }

    public function updateDirectoryServiceOptions($type, $data)
    {
        $this->loadDirectories();

        $this->directories[$type]['service_options'] = $data;

        $this->flush();
    }

    public function getDirectory($type)
    {
        $this->loadDirectories();

        return $this->directories[$type];
    }

    public function getDirectories()
    {
        $this->loadDirectories();

        return $this->directories;
    }

    public function disable($directory)
    {
        $this->loadDirectories();

        $this->directories[$directory]['enabled'] = false;

        $this->flush();
    }

    public function enable($directory)
    {
        $this->loadDirectories();

        $this->directories[$directory]['enabled'] = true;

        $this->flush();
    }

    public function moveDown($directory)
    {
        $this->loadDirectories();

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
        $this->loadDirectories();

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
        if ($this->directories !== null) {
            return $this->directories;
        }

        $this->directories = [];
        $flushRequested = true;

        if (is_file($this->localConfigPath)) {
            $this->directories = include $this->localConfigPath;
            $flushRequested = false;
        }

        foreach ($this->config as $type => $options) {
            if (!array_key_exists($type, $this->directories)) {
                $this->directories[$type] = [];
            }

            $this->populateDirectory($this->directories[$type], $options);
        }

        uasort($this->directories, function($lft, $rgt) {
            return strcmp($lft['priority'], $rgt['priority']);
        });

        $priority = 0;
        foreach ($this->directories as $type => $options) {
            $this->directories[$type]['priority'] = $priority++;
        }

        if ($flushRequested) {
            $this->flush();
        }

        return $this->directories;
    }

    private function flush()
    {
        $writer = new PhpArray();
        $writer->toFile($this->localConfigPath, $this->directories);

        $this->cacheManager->clearModuleCache();
    }

    private function populateDirectory(&$directory, $options)
    {
        $directory['label'] = $options['label'];
        $directory['service_name'] = $options['service_name'];

        if (!array_key_exists('enabled', $directory)) {
            $directory['enabled'] = $options['enabled'];
        }

        if (!array_key_exists('priority', $directory)) {
            $directory['priority'] = 0;
        }

        if (!array_key_exists('service_options', $directory)) {
            $directory['service_options'] = $options['service_options'];
        }

        $this->populateRoute('update', $directory, $options);
        $this->populateRoute('enable', $directory, $options);
        $this->populateRoute('disable', $directory, $options);
    }

    private function populateRoute($name, &$directory, $options)
    {
        if (array_key_exists($name . '_route_name', $options)) {
            $directory[$name . '_route_name'] = $options[$name . '_route_name'];
        } else {
            $directory[$name . '_route_name'] = null;
        }

        if (array_key_exists($name . '_route_params', $options)) {
            $directory[$name . '_route_params'] = $options[$name . '_route_params'];
        } else {
            $directory[$name . '_route_params'] = [];
        }

        if (array_key_exists($name . '_route_options', $options)) {
            $directory[$name . '_route_options'] = $options[$name . '_route_options'];
        } else {
            $directory[$name . '_route_options'] = [];
        }
    }
}
