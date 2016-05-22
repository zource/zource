<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceContact\Mvc\Controller\Service;

use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZourceContact\Form\Account as AccountForm;
use ZourceContact\Form\ChangeIdentity as ChangeIdentityForm;
use ZourceContact\Mvc\Controller\Account;
use ZourceContact\TaskService\PasswordChanger;

class DirectoryFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var AuthenticationService $authenticationService */
        $authenticationService = $serviceLocator->getServiceLocator()->get(
            'Zend\\Authentication\\AuthenticationService'
        );

        /** @var AccountForm $accountForm */
        $accountForm = $serviceLocator->getServiceLocator()->get(AccountForm::class);

        /** @var ChangeIdentityForm $changeIdentityForm */
        $changeIdentityForm = $serviceLocator->getServiceLocator()->get(ChangeIdentityForm::class);

        /** @var PasswordChanger $passwordChanger */
        $passwordChanger = $serviceLocator->getServiceLocator()->get(PasswordChanger::class);

        return new Directory($authenticationService, $accountForm, $changeIdentityForm, $passwordChanger);
    }
}
