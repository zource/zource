<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Mvc\Controller\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Session\Container;
use ZourceUser\Authentication\AuthenticationService;
use ZourceUser\Form\Authenticate as AuthenticateForm;
use ZourceUser\Form\VerifyCode;
use ZourceUser\Mvc\Controller\Authenticate;

class AuthenticateFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var AuthenticationService $authenticationService */
        $authenticationService = $serviceLocator->getServiceLocator()->get(
            'Zend\\Authentication\\AuthenticationService'
        );

        /** @var AuthenticateForm $authenticateForm */
        $authenticateForm = $serviceLocator->getServiceLocator()->get(AuthenticateForm::class);

        /** @var VerifyCode $verifyCodeForm */
        $verifyCodeForm = $serviceLocator->getServiceLocator()->get(VerifyCode::class);

        /** @var Container $authSession */
        $authSession = $serviceLocator->getServiceLocator()->get('ZourceUserSessionAuthenticate');

        return new Authenticate($authenticationService, $authenticateForm, $verifyCodeForm, $authSession);
    }
}
