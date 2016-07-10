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
use ZourceUser\Form\AdminRole;
use ZourceUser\Mvc\Controller\AdminPermissions;
use ZourceUser\Mvc\Controller\AdminRoles;
use ZourceUser\TaskService\Permissions;
use ZourceUser\TaskService\Roles;

class AdminPermissionsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $taskService = $serviceLocator->getServiceLocator()->get(Permissions::class);
        
        return new AdminPermissions($taskService);
    }
}
