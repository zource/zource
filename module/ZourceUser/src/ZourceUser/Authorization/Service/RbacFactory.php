<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Authorization\Service;

use Zend\Permissions\Rbac\Rbac;
use Zend\Permissions\Rbac\Role;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZourceUser\Entity\AccountInterface;
use ZourceUser\Entity\Group;

class RbacFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var AuthenticationService $authenticationService */
        $authenticationService = $serviceLocator->get(
            'Zend\\Authentication\\AuthenticationService'
        );

        /** @var AccountInterface $account */
        $account = $authenticationService->getAccountEntity();

        $role = new Role('account-' . $account->getId()->toString());

        /** @var Group $group */
        foreach ($account->getGroups() as $group) {
            foreach ($group->getPermissions() as $permission) {
                $role->addPermission($permission);
            }
        }

        $rbac = new Rbac();
        $rbac->addRole($role);

        return $rbac;
    }
}
