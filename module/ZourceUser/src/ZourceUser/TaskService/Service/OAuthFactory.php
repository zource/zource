<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\TaskService\Service;

use Closure;
use Doctrine\ORM\EntityManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZourceUser\TaskService\OAuth;

class OAuthFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var Closure $server */
        $server = $serviceLocator->get('ZF\OAuth2\Service\OAuth2Server');

        /** @var EntityManager $entityManager */
        $entityManager = $serviceLocator->get('doctrine.entitymanager.orm_default');

        return new OAuth($server(), $entityManager);
    }
}
