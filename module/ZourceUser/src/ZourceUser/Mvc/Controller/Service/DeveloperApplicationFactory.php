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
use ZourceUser\Form\CreateApplication;
use ZourceUser\Mvc\Controller\DeveloperApplication;
use ZourceUser\TaskService\Application as ApplicationService;

class DeveloperApplicationFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var ApplicationService $applicationService */
        $applicationService = $serviceLocator->getServiceLocator()->get(ApplicationService::class);

        /** @var CreateApplication $createApplicationForm */
        $createApplicationForm = $serviceLocator->getServiceLocator()->get(CreateApplication::class);

        return new DeveloperApplication($applicationService, $createApplicationForm);
    }
}
