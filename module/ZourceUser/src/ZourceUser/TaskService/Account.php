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
use Zend\Math\Rand;
use Zend\Paginator\Paginator;
use ZourceContact\Entity\EmailAddress;
use ZourceContact\Entity\Person;
use ZourceUser\Entity\Account as AccountEntity;
use ZourceUser\Entity\Email;
use ZourceUser\Entity\Group as GroupEntity;

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

        /** @var GroupEntity $group */
        foreach ($account->getGroups() as $group) {
            $this->entityManager->persist($group);
        }

        $this->entityManager->flush();
    }

    public function createAccount($data)
    {
        $person = new Person($data['first_name'], $data['last_name']);
        $person->setMiddleName($data['middle_name']);

        $emailAddress = new EmailAddress($person, EmailAddress::TYPE_WORK, $data['email']);

        $account = new AccountEntity($person);
        $account->setStatus($data['status']);

        $accountEmail = new Email($account, $data['email']);
        $account->getEmailAddresses()->add($accountEmail);

        $this->entityManager->persist($person);
        $this->entityManager->persist($emailAddress);
        $this->entityManager->persist($account);

        $this->entityManager->flush();

        return $account;
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
        $accountEmail->setValidationCode(Rand::getString(32, range('a', 'z')));
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

    public function lookup($queryTerm)
    {
        $dql = "SELECT a.id AS account_id, c AS contact
            FROM ZourceContact\\Entity\\AbstractContact c
            INNER JOIN ZourceUser\\Entity\\AccountInterface a WITH a.contact = c
            LEFT JOIN ZourceContact\\Entity\\Person cp WITH cp.id = c.id
            LEFT JOIN ZourceContact\\Entity\\Company cc WITH cc.id = c.id
            WHERE c.displayName LIKE :query
            OR cc.name LIKE :query
            OR cp.firstName LIKE :query
            OR cp.lastName LIKE :query";

        $query = $this->entityManager->createQuery($dql);
        $query->setParameter(':query', '%' . $queryTerm . '%');

        $result = [];

        foreach ($query->getResult() as $entry) {
            $result[] = [
                'id' => $entry['account_id']->toString(),
                'text' => $entry['contact']->getDisplayName(),
            ];
        }

        return [
            'items' => $result,
        ];
    }
}
