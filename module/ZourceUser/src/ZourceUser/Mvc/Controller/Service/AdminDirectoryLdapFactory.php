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
use ZourceUser\Form\AdminLdap;
use ZourceUser\Mvc\Controller\AdminDirectoryLdap;
use ZourceUser\TaskService\Directory;

class AdminDirectoryLdapFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var Directory $directoryTaskService */
        $directoryTaskService = $serviceLocator->getServiceLocator()->get(Directory::class);

        /** @var AdminLdap $ldapForm */
        $ldapForm = $serviceLocator->getServiceLocator()->get(AdminLdap::class);

        return new AdminDirectoryLdap($directoryTaskService, $ldapForm);
    }
}
