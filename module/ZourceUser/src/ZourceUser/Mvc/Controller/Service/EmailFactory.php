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
use ZourceUser\Form\AddEmail;
use ZourceUser\Form\VerifyEmail;
use ZourceUser\Mvc\Controller\Email;
use ZourceUser\TaskService\Email as EmailTaskService;

class EmailFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var EmailTaskService $emailTaskService */
        $emailTaskService = $serviceLocator->getServiceLocator()->get(EmailTaskService::class);

        /** @var AddEmail $emailForm */
        $emailForm = $serviceLocator->getServiceLocator()->get(AddEmail::class);

        /** @var VerifyEmail $verifyForm */
        $verifyForm = $serviceLocator->getServiceLocator()->get(VerifyEmail::class);

        return new Email($emailTaskService, $emailForm, $verifyForm);
    }
}
