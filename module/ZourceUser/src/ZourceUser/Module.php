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
use Zend\Mvc\MvcEvent;
use Zend\Stdlib\ArrayUtils;
use ZF\Apigility\Provider\ApigilityProviderInterface;
use ZourceUser\Listener\IdentityGuard;
use ZourceUser\Listener\RouteGuard;
use ZourceUser\Listener\Session;

class Module implements ApigilityProviderInterface
{
    public function getConfig()
    {
        return ArrayUtils::merge(
            include __DIR__ . '/../../config/module.config.php',
            include __DIR__ . '/../../config/zource.config.php'
        );
    }

    public function onBootstrap(MvcEvent $e)
    {
        if (!Console::isConsole()) {
            $eventManager = $e->getApplication()->getEventManager();
            
            $guard = new IdentityGuard();
            $guard->attach($eventManager);

            $guard = new RouteGuard();
            $guard->attach($eventManager);

            $session = new Session();
            $session->attach($eventManager);
        }
    }
}
