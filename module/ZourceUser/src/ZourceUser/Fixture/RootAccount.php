<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Fixture;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\Crypt\Password\PasswordInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZourceContact\Entity\Company as CompanyEntity;
use ZourceContact\Entity\Person as PersonEntity;
use ZourceContact\Entity\Person;
use ZourceUser\Entity\Account as AccountEntity;
use ZourceUser\Entity\Account;
use ZourceUser\Entity\Identity;

class RootAccount implements FixtureInterface, OrderedFixtureInterface, ServiceLocatorAwareInterface
{
    private $serviceLocator;

    public function load(ObjectManager $manager)
    {
        /** @var PasswordInterface $password */
        $password = $this->getServiceLocator()->get(PasswordInterface::class);

        $person = new Person('Walter', 'Tamboer');
        $manager->persist($person);

        $account = new Account($person);
        $account->setCredential($password->create('root'));
        $manager->persist($account);

        $identity = new Identity($account, 'username', 'root');
        $manager->persist($identity);

        $manager->flush();
    }

    public function getOrder()
    {
        return 0;
    }

    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }
}
