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
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZourceUser\Entity\AccountInterface;

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

        $rbac = new Rbac();
        $rbac->addRole('account-' . $account->getId()->toString());

        return $rbac;
    }
}
