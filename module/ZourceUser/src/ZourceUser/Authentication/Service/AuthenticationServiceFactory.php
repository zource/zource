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
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZourceUser\Authentication\Adapter\Chain;
use ZourceUser\Authentication\Adapter\Service\PluginManager;
use ZourceUser\Authentication\AuthenticationService;
use ZourceUser\TaskService\Directory as DirectoryTaskService;

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
        /** @var DirectoryTaskService $directoryTaskService */
        $directoryTaskService = $serviceLocator->get(DirectoryTaskService::class);

        /** @var PluginManager $adapterPluginManager */
        $adapterPluginManager = $serviceLocator->get(PluginManager::class);

        $chain = new Chain();

        foreach ($directoryTaskService->getDirectories() as $directory) {
            if (!$directory['enabled']) {
                continue;
            }

            if (!$adapterPluginManager->has($directory['service_name'])) {
                throw new RuntimeException(sprintf(
                    'The service "%s" could not be found.',
                    $directory['service_name']
                ));
            }

            $adapter = $adapterPluginManager->get(
                $directory['service_name'],
                $directory['service_options']
            );

            $chain->addAdapter($adapter);
        }

        return $chain;
    }
}
