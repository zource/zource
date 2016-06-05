<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceContact\Mvc\Controller\Service;

use Zend\Form\FormInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZourceContact\Form\Person as PersonForm;
use ZourceContact\Mvc\Controller\Person;
use ZourceContact\TaskService\Contact as ContactTaskService;

class PersonFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var ContactTaskService $contactTaskService */
        $contactTaskService = $serviceLocator->getServiceLocator()->get(ContactTaskService::class);

        /** @var FormInterface $contactForm */
        $contactForm = $serviceLocator->getServiceLocator()->get('ZourceContactPersonForm');

        return new Person($contactTaskService, $contactForm);
    }
}
