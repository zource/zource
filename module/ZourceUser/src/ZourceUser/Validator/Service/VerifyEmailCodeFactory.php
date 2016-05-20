<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Validator\Service;

use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZourceUser\Validator\VerifyEmailCode;

class VerifyEmailCodeFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $validator = new VerifyEmailCode();
        $validator->setEntityManager($serviceLocator->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
        $validator->setAuthenticationService($serviceLocator->getServiceLocator()->get(AuthenticationService::class));

        return $validator;
    }
}
