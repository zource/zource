<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\UI\Navigation\Item\Service;

use Zend\ServiceManager\Exception;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZourceApplication\TaskService\Dashboard;
use ZourceApplication\UI\Navigation\Item\DashboardList;

class DashboardListFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $view = $serviceLocator->getServiceLocator()->get('ViewRenderer');
        $dashboardTaskService = $serviceLocator->getServiceLocator()->get(Dashboard::class);

        return new DashboardList($view, $dashboardTaskService);
    }
}
