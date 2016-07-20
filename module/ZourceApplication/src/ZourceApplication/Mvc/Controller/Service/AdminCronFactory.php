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
use ZourceApplication\Mvc\Controller\AdminCron;
use ZourceApplication\TaskService\CronManager;

class AdminCronFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var CronManager $cronManager */
        $cronManager = $serviceLocator->getServiceLocator()->get(CronManager::class);

        return new AdminCron($cronManager);
    }
}
