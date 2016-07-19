<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceDaemon\Mvc\Controller\Plugin\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZourceDaemon\Mvc\Controller\Plugin\Daemon;
use ZourceDaemon\TaskService\Daemon as DaemonTaskService;

class DaemonFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $daemonTaskService = $serviceLocator->getServiceLocator()->get(DaemonTaskService::class);

        return new Daemon($daemonTaskService);
    }
}
