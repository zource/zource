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
use ZourceUser\Form\VerifyCode;
use ZourceUser\Mvc\Controller\TwoFactorAuthentication;
use ZourceUser\TaskService\TwoFactorAuthentication as TwoFactorAuthenticationService;

class TwoFactorAuthenticationFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var TwoFactorAuthenticationService $tfaService */
        $tfaService = $serviceLocator->getServiceLocator()->get(TwoFactorAuthenticationService::class);

        /** @var VerifyCode $verifyCodeForm */
        $verifyCodeForm = $serviceLocator->getServiceLocator()->get(VerifyCode::class);

        return new TwoFactorAuthentication($tfaService, $verifyCodeForm);
    }
}
