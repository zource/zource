<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication;

use Zend\Log\Logger;
use Zend\Log\Writer\Stream;
use Zend\ModuleManager\Feature\ConsoleBannerProviderInterface;
use Zend\Console\Adapter\AdapterInterface as ConsoleAdapter;
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

class Module implements ApigilityProviderInterface, ConsoleBannerProviderInterface
{
    public function getConfig()
    {
        return ArrayUtils::merge(
            include __DIR__ . '/../../config/module.config.php',
            include __DIR__ . '/../../config/zource.config.php'
        );
    }

    public function getConsoleBanner(ConsoleAdapter $console)
    {
        return 'Zource';
    }

    public function init(ModuleManager $moduleManager)
    {
        /** @var ServiceListener $serviceListener */
        $serviceListener = $moduleManager->getEvent()->getParam('ServiceManager')->get('ServiceListener');
        $serviceListener->addServiceManager(AuthorizationConditionPluginManager::class, 'zource_conditions', '', '');
        $serviceListener->addServiceManager(UiNavigationItemPluginManager::class, 'zource_ui_nav_items', '', '');

        $logger = new Logger([
            'exceptionhandler' => true,
            'errorhandler' => true,
            'fatal_error_shutdownfunction' => true,
        ]);
        $logger->addWriter(new Stream('data/logs/php_log.' . date('Y-m-d')));
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
            $formElementErrors->setMessageSeparatorString('</div><div class="zui-error">');
            $formElementErrors->setMessageCloseString('</div>');

            $flashMessenger = $viewHelperManager->get('flashMessenger');
            $flashMessenger->setMessageOpenFormat('<div class="zui-alert zui-alert-%s"><p>');
            $flashMessenger->setMessageSeparatorString('</p><p>');
            $flashMessenger->setMessageCloseString('</p><span class="zui-icon zui-icon-x" role="button" tabindex="0"></span></div>');

            /** @var ManagerInterface $sessionManager */
            $sessionManager = $e->getApplication()->getServiceManager()->get(ManagerInterface::class);
            $sessionManager->start();
        }
    }
}
