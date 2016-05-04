<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Listener;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;

class RouteGuard extends AbstractListenerAggregate
{
    public function attach(EventManagerInterface $events)
    {
        $events->attach(MvcEvent::EVENT_ROUTE, [$this, 'onRoute'], -100);
    }

    public function onRoute(MvcEvent $e)
    {
        $serviceManager = $e->getApplication()->getServiceManager();
        $routeMatchName = $e->getRouteMatch()->getMatchedRouteName();

        if (strpos($routeMatchName, '.rest.') !== false || strpos($routeMatchName, '.rpc.') !== false) {
            return;
        }

        $config = $serviceManager->get('Config');
        $routeGuards = $config['zource']['guard']['routes'];

        $routeOptions = null;

        foreach ($routeGuards as $guard => $options) {
            if (fnmatch($guard, $routeMatchName)) {
                $routeOptions = $options;
                break;
            }
        }

        if ($routeOptions === null) {
            return;
        }

        var_dump(__FILE__);
        var_dump($routeOptions);
        exit;
    }
}
