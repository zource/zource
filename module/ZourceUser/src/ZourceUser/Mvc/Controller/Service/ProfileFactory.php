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
use ZourceUser\Authentication\AuthenticationService;
use ZourceUser\Form\Profile as ProfileForm;
use ZourceUser\Mvc\Controller\Profile;

class ProfileFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var AuthenticationService $authenticationService */
        $authenticationService = $serviceLocator->getServiceLocator()->get(
            'Zend\\Authentication\\AuthenticationService'
        );

        /** @var ProfileForm $profileForm */
        $profileForm = $serviceLocator->getServiceLocator()->get(
            ProfileForm::class
        );

        return new Profile($authenticationService, $profileForm);
    }
}
