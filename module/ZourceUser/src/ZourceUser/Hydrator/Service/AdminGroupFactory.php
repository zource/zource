<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Hydrator\Service;

use Zend\Hydrator\ClassMethods;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZourceUser\Hydrator\Strategy\Accounts;
use ZourceUser\TaskService\Account;

class AdminGroupFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $accountTaskService = $serviceLocator->getServiceLocator()->get(Account::class);

        $hydrartor = new ClassMethods();
        $hydrartor->addStrategy('accounts', new Accounts($accountTaskService));
        
        return $hydrartor;
    }
}
