<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceContact\Mvc\Controller\Service;

use Zend\Authentication\AuthenticationService;
use Zend\Crypt\Password\PasswordInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZourceContact\Mvc\Controller\Account;
use ZourceContact\Mvc\Controller\Console;
use ZourceContact\TaskService\PasswordChanger;

class ConsoleFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $serviceLocator->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        /** @var PasswordInterface $crypter */
        $crypter = $serviceLocator->getServiceLocator()->get(PasswordInterface::class);

        return new Console($entityManager, $crypter);
    }
}
