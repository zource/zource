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
use ZourceUser\Mvc\Controller\Lookup;
use ZourceUser\TaskService\Account;
use ZourceUser\TaskService\Group;

class LookupFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var Account $accountTaskService */
        $accountTaskService = $serviceLocator->getServiceLocator()->get(Account::class);

        /** @var Group $groupTaskService */
        $groupTaskService = $serviceLocator->getServiceLocator()->get(Group::class);

        return new Lookup($accountTaskService, $groupTaskService);
    }
}
