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
use ZourceApplication\Mvc\Controller\IncomingMail;
use ZourceDaemon\TaskService\Daemon;

class IncomingMailFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var Daemon $daemonTaskService */
        $daemonTaskService = $serviceLocator->getServiceLocator()->get(Daemon::class);

        return new IncomingMail($daemonTaskService);
    }
}
