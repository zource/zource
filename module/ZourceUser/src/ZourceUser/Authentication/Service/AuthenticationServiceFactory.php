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
use RuntimeException;
use Zend\Authentication\Storage\Session;
use Zend\Authentication\Storage\StorageInterface;
use Zend\Crypt\Password\PasswordInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZourceUser\Authentication\Adapter\Chain;
use ZourceUser\Authentication\AuthenticationService;
use ZourceUser\TaskService\Directory as DirectoryTaskService;
use ZourceUser\ValueObject\Directory;

class AuthenticationServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $serviceLocator->get('doctrine.entitymanager.orm_default');

        /** @var Chain $chain */
        $chain = $this->buildChain($serviceLocator);

        /** @var StorageInterface $storage */
        $storage = new Session();

        return new AuthenticationService($entityManager, $storage, $chain);
    }

    private function buildChain(ServiceLocatorInterface $serviceLocator)
    {
        /** @var DirectoryTaskService $crypter */
        $directoryTaskService = $serviceLocator->get(DirectoryTaskService::class);

        $chain = new Chain();

        /** @var Directory $directory */
        foreach ($directoryTaskService->getDirectories() as $directory) {
            if (!$directory->getEnabled()) {
                continue;
            }

            if (!$serviceLocator->has($directory->getServiceName())) {
                throw new RuntimeException(sprintf(
                    'The service "%s" could not be found.',
                    $directory->getServiceName()
                ));
            }
            
            $adapter = $serviceLocator->get($directory->getServiceName(), $directory->getServiceOptions());

            $chain->addAdapter($adapter);

            //$chain->addAdapter(new Zource($entityManager, $directoryTaskService->getDirectories(), $crypter));
        }

        return $chain;
    }
}
