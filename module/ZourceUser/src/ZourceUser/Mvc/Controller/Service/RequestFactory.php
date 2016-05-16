<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Mvc\Controller\Service;

use Doctrine\ORM\EntityManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZourceUser\Form\RequestPassword;
use ZourceUser\Form\ResetPassword;
use ZourceUser\Mvc\Controller\Request;
use ZourceUser\TaskService\PasswordChanger;

class RequestFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var PasswordChanger $passwordChanger */
        $passwordChanger = $serviceLocator->getServiceLocator()->get(PasswordChanger::class);

        /** @var RequestPassword $requestPasswordForm */
        $requestPasswordForm = $serviceLocator->getServiceLocator()->get(RequestPassword::class);

        /** @var ResetPassword $resetPasswordForm */
        $resetPasswordForm = $serviceLocator->getServiceLocator()->get(ResetPassword::class);

        return new Request($passwordChanger, $requestPasswordForm, $resetPasswordForm);
    }
}
