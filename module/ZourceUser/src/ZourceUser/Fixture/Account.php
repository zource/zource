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
use ZourceContact\Entity\Person;
use ZourceUser\Entity\Account as AccountEntity;
use ZourceUser\Entity\Identity;

class Account implements FixtureInterface, OrderedFixtureInterface, ServiceLocatorAwareInterface
{
    private $serviceLocator;

    public function load(ObjectManager $manager)
    {
        /** @var PasswordInterface $password */
        $password = $this->getServiceLocator()->get(PasswordInterface::class);

        for ($i = 0; $i < 10; ++$i) {
            $person = new Person('Account', $i);
            $manager->persist($person);

            $account = new AccountEntity($person);
            $account->setCredential($password->create('account' . $i));
            $manager->persist($account);

            $identity = new Identity($account, 'username', 'account' . $i);
            $manager->persist($identity);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
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
