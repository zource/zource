<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication;

use Zend\Console\Console;
use Zend\ModuleManager\Listener\ServiceListener;
use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\ManagerInterface;
use Zend\Stdlib\ArrayUtils;
use ZF\Apigility\Provider\ApigilityProviderInterface;
use ZourceApplication\Authorization\Condition\Service\PluginManager as AuthorizationConditionPluginManager;
use ZourceApplication\Ui\Navigation\Item\Service\PluginManager as UiNavigationItemPluginManager;

class Module implements ApigilityProviderInterface
{
    public function getConfig()
    {
        return ArrayUtils::merge(
            include __DIR__ . '/../../config/module.config.php',
            include __DIR__ . '/../../config/zource.config.php'
        );
    }

    public function init(ModuleManager $moduleManager)
    {
        /** @var ServiceListener $serviceListener */
        $serviceListener = $moduleManager->getEvent()->getParam('ServiceManager')->get('ServiceListener');
        $serviceListener->addServiceManager(AuthorizationConditionPluginManager::class, 'zource_conditions', '', '');
        $serviceListener->addServiceManager(UiNavigationItemPluginManager::class, 'zource_ui_nav_items', '', '');
    }

    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();

        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        if (!Console::isConsole()) {
            $viewHelperManager = $e->getApplication()->getServiceManager()->get('ViewHelperManager');

            $formElementErrors = $viewHelperManager->get('formElementErrors');
            $formElementErrors->setMessageOpenFormat('<div class="zui-error">');
            $formElementErrors->setMessageSeparatorString('</div><div>');
            $formElementErrors->setMessageCloseString('</div>');

            /** @var ManagerInterface $sessionManager */
            $sessionManager = $e->getApplication()->getServiceManager()->get(ManagerInterface::class);
            $sessionManager->start();
        }
    }
}
