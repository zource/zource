<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\Mvc\Controller\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZourceApplication\Form\IncomingEmailAccount;
use ZourceApplication\Mvc\Controller\AdminEmailIncoming;
use ZourceApplication\TaskService\EmailServers;

class AdminEmailIncomingFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var EmailServers $emailServers */
        $emailServers = $serviceLocator->getServiceLocator()->get(EmailServers::class);

        /** @var IncomingEmailAccount $accountForm */
        $accountForm = $serviceLocator->getServiceLocator()->get(IncomingEmailAccount::class);

        return new AdminEmailIncoming($emailServers, $accountForm);
    }
}
