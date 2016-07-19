<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceDaemon;

use Zend\Console\Adapter\AdapterInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Zend\ModuleManager\Feature\InitProviderInterface;
use Zend\ModuleManager\Listener\ServiceListener;
use Zend\ModuleManager\ModuleManagerInterface;
use ZourceDaemon\Service\WorkerManager;

class Module implements ConfigProviderInterface, ConsoleUsageProviderInterface, InitProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    public function getConsoleUsage(AdapterInterface $console)
    {
        return [
            'zource:daemon:run' => 'Runs the daemon',
        ];
    }

    public function init(ModuleManagerInterface $moduleManager)
    {
        /** @var ServiceListener $serviceListener */
        $serviceListener = $moduleManager->getEvent()->getParam('ServiceManager')->get(ServiceListener::class);
        $serviceListener->addServiceManager(WorkerManager::class, 'zource_workers', '', '');
    }
}
