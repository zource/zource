<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\TaskService\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZourceApplication\TaskService\CacheManager;
use ZourceUser\TaskService\Directory;

class DirectoryFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var array $config */
        $config = $serviceLocator->get('Config');

        /** @var CacheManager $cacheManager */
        $cacheManager = $serviceLocator->get(CacheManager::class);

        return new Directory(
            'config/autoload/zource.auth-directories.local.php',
            $config['zource_auth_directories'],
            $cacheManager
        );
    }
}
