<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceContact\Authorization\Condition\Service;

use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZourceContact\Authorization\Condition\ContactIsCurrentAccount;

class ContactIsCurrentAccountFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new ContactIsCurrentAccount(
            $serviceLocator->getServiceLocator()->get('ViewRenderer'),
            $serviceLocator->getServiceLocator()->get(AuthenticationService::class)
        );
    }
}
