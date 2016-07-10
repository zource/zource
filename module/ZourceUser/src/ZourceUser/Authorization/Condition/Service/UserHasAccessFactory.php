<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Authorization\Condition\Service;

use Zend\Permissions\Rbac\Rbac;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\MutableCreationOptionsInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZourceUser\Authorization\Condition\UserHasAccess;

class UserHasAccessFactory implements FactoryInterface, MutableCreationOptionsInterface
{
    private $creationOptions;

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $authenticationService = $serviceLocator->getServiceLocator()->get(
            'Zend\\Authentication\\AuthenticationService'
        );

        $authorizationService = $serviceLocator->getServiceLocator()->get(Rbac::class);

        return new UserHasAccess(
            $authenticationService,
            $authorizationService,
            $this->creationOptions['resource'],
            $this->creationOptions['permission']
        );
    }

    public function setCreationOptions(array $options)
    {
        $this->creationOptions = $options;
    }
}
