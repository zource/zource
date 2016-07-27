<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication;

use Zend\Console\Adapter\AdapterInterface as ConsoleAdapter;
use Zend\Console\Console;
use Zend\EventManager\EventInterface;
use Zend\Filter\FilterChain;
use Zend\Filter\StringToLower;
use Zend\Filter\Word\CamelCaseToUnderscore;
use Zend\Hydrator\ObjectProperty;
use Zend\Log\Formatter\Xml;
use Zend\Log\Logger;
use Zend\Log\Writer\Stream;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ConsoleBannerProviderInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Zend\ModuleManager\Feature\InitProviderInterface;
use Zend\ModuleManager\Listener\ServiceListener;
use Zend\ModuleManager\ModuleManagerInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\ManagerInterface;
use Zend\Stdlib\ArrayUtils;
use ZF\Apigility\Provider\ApigilityProviderInterface;
use ZourceApplication\Authorization\Condition\Service\PluginManager as AuthorizationConditionPluginManager;
use ZourceApplication\Ui\Navigation\Item\Service\PluginManager as UiNavigationItemPluginManager;

class Module implements
    ApigilityProviderInterface,
    ConfigProviderInterface,
    ConsoleBannerProviderInterface,
    ConsoleUsageProviderInterface,
    InitProviderInterface
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

    public function getConsoleUsage(ConsoleAdapter $console)
    {
        return [
            'zource:incoming-mail:check' => 'Checks configured accounts for incoming mail.',
        ];
    }

    public function init(ModuleManagerInterface $moduleManager)
    {
        /** @var ServiceListener $serviceListener */
        $serviceListener = $moduleManager->getEvent()->getParam('ServiceManager')->get('ServiceListener');
        $serviceListener->addServiceManager(AuthorizationConditionPluginManager::class, 'zource_conditions', '', '');
        $serviceListener->addServiceManager(UiNavigationItemPluginManager::class, 'zource_ui_nav_items', '', '');

        $this->initializeErrorLogging();
    }

    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $serviceManager = $e->getApplication()->getServiceManager();

        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        if (!Console::isConsole()) {
            $viewHelperManager = $serviceManager->get('ViewHelperManager');

            $formElementErrors = $viewHelperManager->get('formElementErrors');
            $formElementErrors->setMessageOpenFormat('<div class="zui-error">');
            $formElementErrors->setMessageSeparatorString('</div><div class="zui-error">');
            $formElementErrors->setMessageCloseString('</div>');

            $flashMessenger = $viewHelperManager->get('flashMessenger');
            $flashMessenger->setMessageOpenFormat('<div class="zui-alert zui-alert-%s"><p>');
            $flashMessenger->setMessageSeparatorString('</p><p>');
            $flashMessenger->setMessageCloseString('</p><span class="zui-icon zui-icon-x" role="button" tabindex="0"></span></div>');

            /** @var ManagerInterface $sessionManager */
            $sessionManager = $serviceManager->get(ManagerInterface::class);
            $sessionManager->start();
        }

        $helpers = $serviceManager->get('ViewHelperManager');

        $hal = $helpers->get('Hal');
        $hal->getEventManager()->attach('renderCollection.post', [$this, 'onRenderCollection']);
        $hal->getEventManager()->attach('renderEntity.post', [$this, 'onRenderEntity']);
    }

    public function onRenderCollection(EventInterface $e)
    {
        $payload = $e->getParam('payload');

        foreach ($payload['_embedded'] as $key => $items) {
            foreach ($items as $index => $item) {
                $payload['_embedded'][$key][$index] = $this->parsePayload($item);
            }
        }
    }

    public function onRenderEntity(EventInterface $e)
    {
        $payload = $e->getParam('payload');

        $newPayload = $this->parsePayload($payload);

        $e->setParam('payload', $newPayload);
    }

    private function parsePayload($payload)
    {
        $filterChain = new FilterChain();
        $filterChain->attach(new CamelCaseToUnderscore());
        $filterChain->attach(new StringToLower());

        // Collections provide an array and entities provide an array object. We need to modify the
        // collection else the data won't be updated.
        if ($payload instanceof \ArrayObject) {
            $backup = clone $payload;
            $newPayload = $payload;
            $newPayload->exchangeArray([]);
        } else {
            $backup = $payload;
            $newPayload = [];
        }

        foreach ($backup as $name => $value) {
            if ($value instanceof \DateTimeInterface) {
                $value->setTimezone(new \DateTimeZone("UTC"));
                $value = $value->format('c');
            }

            $newPayload[$filterChain->filter($name)] = $value;
        }

        return $newPayload;
    }

    private function initializeErrorLogging()
    {
        $writer = new Stream('data/logs/php_log.' . date('Y-m-d') . '.xml');
        $writer->setFormatter(new Xml([
            'rootElement' => 'log',
        ]));

        $logger = new Logger([
            'exceptionhandler' => true,
            'errorhandler' => true,
            'fatal_error_shutdownfunction' => true,
        ]);
        $logger->addWriter($writer);
    }
}
