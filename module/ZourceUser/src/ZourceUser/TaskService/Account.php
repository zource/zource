<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\TaskService;

use Doctrine\ORM\EntityManager;
use DoctrineModule\Paginator\Adapter\Selectable;
use Zend\EventManager\EventManager;
use Zend\Paginator\Paginator;
use ZourceContact\Entity\EmailAddress;
use ZourceContact\Entity\Person;
use ZourceUser\Entity\Account as AccountEntity;
use ZourceUser\Entity\Email;

class Account
{
    private $entityManager;
    private $eventManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->eventManager = new EventManager([
            'account-task-service',
        ]);
    }

    public function getEventManager()
    {
        return $this->eventManager;
    }

    public function find($id)
    {
        $repository = $this->entityManager->getRepository(AccountEntity::class);

        return $repository->find($id);
    }

    public function remove(AccountEntity $account)
    {
        $this->entityManager->remove($account);
        $this->entityManager->flush($account);
    }

    public function persist(AccountEntity $account)
    {
        $this->entityManager->persist($account);
        $this->entityManager->flush($account);
    }

    public function persistFromArray(array $data)
    {
    }

    public function inviteAccount($data)
    {
        // Lookup the e-mail address:
        $repository = $this->entityManager->getRepository(Email::class);
        $accountEmail = $repository->findOneBy(['address' => $data['email']]);

        if ($accountEmail !== null) {
            return $accountEmail->getAccount();
        }

        $person = new Person($data['first_name'], $data['last_name']);
        $person->setMiddleName($data['middle_name']);

        $emailAddress = new EmailAddress($person, EmailAddress::TYPE_WORK, $data['email']);

        $account = new AccountEntity($person);
        $account->setStatus(AccountEntity::STATUS_INVITED);

        $accountEmail = new Email($account, $data['email']);
        $accountEmail->setValidationCode('abc');
        $account->getEmailAddresses()->add($accountEmail);

        $this->entityManager->persist($person);
        $this->entityManager->persist($emailAddress);
        $this->entityManager->persist($account);

        $this->entityManager->flush();

        return $account;
    }

    public function getPaginator()
    {
        $repository = $this->entityManager->getRepository(AccountEntity::class);
        $adapter = new Selectable($repository);

        return new Paginator($adapter);
    }
}
