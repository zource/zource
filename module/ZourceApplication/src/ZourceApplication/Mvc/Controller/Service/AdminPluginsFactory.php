<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\Mvc\Controller\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZourceApplication\Form\InstallPlugin;
use ZourceApplication\Mvc\Controller\AdminPlugins;
use ZourceApplication\TaskService\PluginManager;

class AdminPluginsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var InstallPlugin $installForm */
        $installForm = $serviceLocator->getServiceLocator()->get(InstallPlugin::class);

        /** @var PluginManager $installForm */
        $pluginManager = $serviceLocator->getServiceLocator()->get(PluginManager::class);

        return new AdminPlugins($installForm, $pluginManager);
    }
}
