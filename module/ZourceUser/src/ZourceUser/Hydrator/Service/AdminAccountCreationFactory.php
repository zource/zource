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
use ZourceUser\Hydrator\Strategy\Groups;
use ZourceUser\TaskService\Group;

class AdminAccountCreationFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $groupTaskService = $serviceLocator->getServiceLocator()->get(Group::class);

        $hydrartor = new ClassMethods();
        $hydrartor->addStrategy('groups', new Groups($groupTaskService));
        
        return $hydrartor;
    }
}
