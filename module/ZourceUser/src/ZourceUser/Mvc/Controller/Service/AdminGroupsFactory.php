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
use ZourceUser\Form\AdminGroup;
use ZourceUser\Mvc\Controller\AdminGroups;

class AdminGroupsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $form = $serviceLocator->getServiceLocator()->get(AdminGroup::class);
        $taskService = $serviceLocator->getServiceLocator()->get(Roles::class);

        return new AdminGroups($form, $taskService);
    }
}
