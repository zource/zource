<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Mvc\Controller\Plugin\Service;

use Doctrine\ORM\EntityManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZourceUser\Mvc\Controller\Plugin\Account;

class AccountFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $serviceLocator->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        /** @var AuthenticationService $authenticationService */
        $authenticationService = $serviceLocator->getServiceLocator()->get(
            'Zend\\Authentication\\AuthenticationService'
        );

        return new Account($entityManager, $authenticationService);
    }
}
