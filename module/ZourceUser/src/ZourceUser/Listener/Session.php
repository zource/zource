<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Listener;

use Doctrine\ORM\EntityManager;
use Zend\Authentication\AuthenticationService;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;
use Zend\Session\ManagerInterface;
use ZourceApplication\Entity\Session as SessionEntity;
use ZourceUser\Authentication\AuthenticationService as ZourceAuthenticationService;

class Session extends AbstractListenerAggregate
{
    public function attach(EventManagerInterface $events)
    {
        $events->attach(MvcEvent::EVENT_FINISH, [$this, 'onPostLogin'], -1);
        $events->attach(MvcEvent::EVENT_FINISH, [$this, 'onPostLogout'], -1);
    }

    public function onPostLogin(MvcEvent $e)
    {
        if (!$e->getRouteMatch()) {
            return;
        }

        /** @var string $matchedRouteName */
        $matchedRouteName = $e->getRouteMatch()->getMatchedRouteName();

        if ($matchedRouteName !== 'login') {
            return;
        }

        if (!$e->getRequest()->isPost()) {
            return;
        }

        /** @var ZourceAuthenticationService $authenticationService */
        $authenticationService = $e->getApplication()->getServiceManager()->get(AuthenticationService::class);

        /** @var ManagerInterface $sessionManager */
        $sessionManager = $e->getApplication()->getServiceManager()->get(ManagerInterface::class);

        /** @var EntityManager $entityManager */
        $entityManager = $e->getApplication()->getServiceManager()->get('doctrine.entitymanager.orm_default');

        /** @var SessionEntity $respository */
        $respository = $entityManager->getRepository(SessionEntity::class);

        /** @var SessionEntity $session */
        $session = $respository->find($sessionManager->getId());
        $session->setAccount($authenticationService->getAccountInterface());

        $entityManager->persist($session);
        $entityManager->flush($session);
    }

    public function onPostLogout(MvcEvent $e)
    {
        if (!$e->getRouteMatch()) {
            return;
        }

        /** @var string $matchedRouteName */
        $matchedRouteName = $e->getRouteMatch()->getMatchedRouteName();

        if ($matchedRouteName !== 'logout') {
            return;
        }

        /** @var ManagerInterface $sessionManager */
        $sessionManager = $e->getApplication()->getServiceManager()->get(ManagerInterface::class);

        /** @var EntityManager $entityManager */
        $entityManager = $e->getApplication()->getServiceManager()->get('doctrine.entitymanager.orm_default');

        /** @var SessionEntity $respository */
        $respository = $entityManager->getRepository(SessionEntity::class);

        /** @var SessionEntity $session */
        $session = $respository->find($sessionManager->getId());
        $session->setAccount(null);

        $entityManager->persist($session);
        $entityManager->flush($session);
    }
}
