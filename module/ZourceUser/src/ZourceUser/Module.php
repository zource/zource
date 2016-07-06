<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser;

use Zend\Console\Console;
use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\MvcEvent;
use Zend\Stdlib\ArrayUtils;
use ZF\Apigility\Provider\ApigilityProviderInterface;
use ZourceUser\Authentication\Adapter\Service\PluginManager;
use ZourceUser\Listener\IdentityGuard;
use ZourceUser\Listener\RouteGuard;
use ZourceUser\Listener\Session;

class Module implements ApigilityProviderInterface
{
    public function init(ModuleManager $moduleManager)
    {
        $sm = $moduleManager->getEvent()->getParam('ServiceManager');

        $serviceListener = $sm->get('ServiceListener');
        $serviceListener->addServiceManager(
            PluginManager::class,
            'zource_auth_adapters',
            '',
            ''
        );
    }

    public function getConfig()
    {
        return ArrayUtils::merge(
            include __DIR__ . '/../../config/module.config.php',
            include __DIR__ . '/../../config/zource.config.php'
        );
    }

    public function getConsoleUsage()
    {
        return [
            'zource:account:create [--first-name=] [--family-name=] [--credential=]' => 'Creates a new account',
            ['first-name', 'The first name of the person that owns the account.'],
            ['last-name', 'The last name of the person that owns the account.'],
            ['credential', 'The plain text credential to set.'],

            'zource:account:delete <id>' => 'Deletes the account with the given id',
            ['id', 'The UUID of the account to delete.'],

            'zource:identity:create <account> <directory> <identity>' => 'Creates a new identity for the given account.',
            ['account', 'The UUID of the account to create the identity for.'],
            ['directory', 'The name of the directory to create the identity in.'],
            ['identity', 'The identity to create.'],

            'zource:identity:delete <id>' => 'Deletes the account with the given id',
            ['id', 'The UUID of the identity to delete.'],
        ];
    }

    public function onBootstrap(MvcEvent $e)
    {
        if (Console::isConsole()) {
            return;
        }

        $eventManager = $e->getApplication()->getEventManager();

        $guard = new IdentityGuard();
        $guard->attach($eventManager);

        $guard = new RouteGuard();
        $guard->attach($eventManager);

        $session = new Session();
        $session->attach($eventManager);
    }
}
