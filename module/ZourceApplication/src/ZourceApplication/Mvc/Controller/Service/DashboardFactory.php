<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\Mvc\Controller\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZourceApplication\Form\Dashboard as DashboardForm;
use ZourceApplication\Mvc\Controller\Dashboard;
use ZourceApplication\TaskService\Dashboard as DashboardTaskService;
use ZourceApplication\TaskService\Gadget as GadgetTaskService;

class DashboardFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var DashboardForm $dashboardForm */
        $dashboardForm = $serviceLocator->getServiceLocator()->get(DashboardForm::class);

        /** @var DashboardTaskService $dashboardTaskService */
        $dashboardTaskService = $serviceLocator->getServiceLocator()->get(DashboardTaskService::class);

        /** @var GadgetTaskService $gadgetTaskService */
        $gadgetTaskService = $serviceLocator->getServiceLocator()->get(GadgetTaskService::class);

        return new Dashboard($dashboardForm, $dashboardTaskService, $gadgetTaskService);
    }
}
