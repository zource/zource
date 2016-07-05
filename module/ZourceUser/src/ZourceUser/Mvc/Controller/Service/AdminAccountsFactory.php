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
use ZourceUser\Form\AdminAccount;
use ZourceUser\Form\AdminInvite;
use ZourceUser\Mvc\Controller\AdminAccounts;
use ZourceUser\TaskService\Account;

class AdminAccountsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $inviteForm = $serviceLocator->getServiceLocator()->get(AdminInvite::class);
        $accountForm = $serviceLocator->getServiceLocator()->get(AdminAccount::class);
        $taskService = $serviceLocator->getServiceLocator()->get(Account::class);

        return new AdminAccounts($inviteForm, $accountForm, $taskService);
    }
}
