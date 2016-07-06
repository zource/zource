<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Authentication\Adapter\Service;

use Zend\Crypt\Password\PasswordInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\MutableCreationOptionsInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZourceUser\Authentication\Adapter\Ldap;

class LdapFactory implements FactoryInterface, MutableCreationOptionsInterface
{
    private $creationOptions;

    public function __construct()
    {
        $this->creationOptions = [];
    }

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $serviceLocator->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        $adapter = new Ldap($entityManager, $this->creationOptions);

        $this->creationOptions = [];

        return $adapter;
    }

    public function setCreationOptions(array $options)
    {
        $this->creationOptions = $options;
    }
}
