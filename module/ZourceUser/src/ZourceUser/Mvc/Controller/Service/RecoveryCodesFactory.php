<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Mvc\Controller\Service;

use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Session\Container;
use ZourceApplication\TaskService\Session;
use ZourceUser\Mvc\Controller\RecoveryCodes;
use ZourceUser\Mvc\Controller\TwoFactorAuthentication;

class RecoveryCodesFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var AuthenticationService $authenticationService */
        $authenticationService = $serviceLocator->getServiceLocator()->get(
            'Zend\\Authentication\\AuthenticationService'
        );

        /** @var Session $sessionService */
        $sessionService = $serviceLocator->getServiceLocator()->get(Session::class);

        /** @var Container $session2FA */
        $session2FA = $serviceLocator->getServiceLocator()->get('ZourceUserSession2FA');

        return new RecoveryCodes($authenticationService, $sessionService, $session2FA, $verifyCodeForm);
    }
}
