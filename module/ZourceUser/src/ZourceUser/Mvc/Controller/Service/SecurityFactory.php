<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Mvc\Controller\Service;

use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZourceApplication\TaskService\RemoteAddressLookup;
use ZourceUser\Mvc\Controller\Security;

class SecurityFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var AuthenticationService $authenticationService */
        $authenticationService = $serviceLocator->getServiceLocator()->get(
            'Zend\\Authentication\\AuthenticationService'
        );

        /** @var RemoteAddressLookup $remoteAddressLookup */
        $remoteAddressLookup = $serviceLocator->getServiceLocator()->get(RemoteAddressLookup::class);

        return new Security($authenticationService, $remoteAddressLookup);
    }
}
