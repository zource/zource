<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Mvc\Controller\Service;

use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZourceUser\Mvc\Controller\Application;
use ZourceUser\TaskService\Application as ApplicationService;

class ApplicationFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var ApplicationService $applicationService */
        $applicationService = $serviceLocator->getServiceLocator()->get(ApplicationService::class);

        return new Application($applicationService);
    }
}
