<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Listener;

use RuntimeException;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;

class IdentityGuard extends AbstractListenerAggregate
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
        $identityGuards = $config['zource']['guard']['identity'];
        $needsIdentity = null;

        foreach ($identityGuards as $guard => $needed) {
            if (fnmatch($guard, $routeMatchName)) {
                $needsIdentity = $needed;
                break;
            }
        }

        if ($needsIdentity === null) {
            throw new RuntimeException(sprintf('The identity guard "%s" has not been configured.', $routeMatchName));
        }

        if (!$needsIdentity) {
            return;
        }

        $authenticationService = $serviceManager->get('Zend\\Authentication\\AuthenticationService');
        if ($authenticationService->hasIdentity()) {
            return;
        }

        $returnUrl = $e->getRouter()->assemble([], [
            'name' => $routeMatchName,
            'force_canonical' => true,
            'query' => $e->getRequest()->getUri()->getQuery(),
        ]);


        $url = $e->getRouter()->assemble([], [
            'name' => 'login',
            'query' => [
                'redir' => $returnUrl,
            ],
        ]);

        $response = new Response();
        $response->setStatusCode(Response::STATUS_CODE_302);
        $response->getHeaders()->addHeaderLine('Location: ' . $url);

        return $response;
    }
}
