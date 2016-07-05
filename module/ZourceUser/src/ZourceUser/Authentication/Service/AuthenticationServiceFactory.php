<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Authentication\Service;

use Doctrine\ORM\EntityManager;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Storage\Session;
use Zend\Authentication\Storage\StorageInterface;
use Zend\Crypt\Password\PasswordInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZourceUser\Authentication\Adapter\Zource;
use ZourceUser\Authentication\AuthenticationService;

class AuthenticationServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $serviceLocator->get('doctrine.entitymanager.orm_default');

        /** @var PasswordInterface $crypter */
        $crypter = $serviceLocator->get(PasswordInterface::class);

        /** @var AdapterInterface $adapter */
        $adapter = new Zource($entityManager, ['username', 'email'], $crypter);

        /** @var StorageInterface $storage */
        $storage = new Session();

        return new AuthenticationService($entityManager, $storage, $adapter);
    }
}
