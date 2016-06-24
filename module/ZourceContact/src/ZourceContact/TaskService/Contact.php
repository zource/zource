<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceContact\TaskService;

use Doctrine\ORM\EntityManager;
use RuntimeException;
use Zend\Hydrator\ClassMethods;
use Zend\Paginator\Paginator;
use ZourceContact\Entity\AbstractContact;
use ZourceContact\Entity\Company;
use ZourceContact\Entity\Person;
use ZourceContact\Paginator\Adapter\ContactOverview;
use ZourceContact\ValueObject\ContactEntry;

class Contact
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function find($id)
    {
        try {
            $repository = $this->entityManager->getRepository(AbstractContact::class);

            return $repository->find($id);
        } catch (\Exception $e) {

        }

        return null;
    }

    public function findCompany($id)
    {
        $contact = $this->find($id);

        if (!$contact instanceof Company) {
            throw new RuntimeException('No company found for this id.');
        }

        return $contact;
    }

    public function findPerson($id)
    {
        $contact = $this->find($id);

        if (!$contact instanceof Person) {
            throw new RuntimeException('No person found for this id.');
        }

        return $contact;
    }

    public function getOverviewPaginator($filter)
    {
        $adapter = new ContactOverview($this->entityManager, $filter);

        return new Paginator($adapter);
    }

    public function createCompany(array $data)
    {
        $company = new Company($data['name']);

        $hydrator = new ClassMethods();
        $hydrator->hydrate($data, $company);

        return $this->persistContact($company);
    }

    public function createPerson(array $data)
    {
        $person = new Person($data['first_name'], $data['last_name']);

        $hydrator = new ClassMethods();
        $hydrator->hydrate($data, $person);

        return $this->persistContact($person);
    }

    public function persistContact(AbstractContact $contact)
    {
        $this->entityManager->persist($contact);
        $this->entityManager->flush($contact);

        return $contact;
    }

    public function deleteContact(AbstractContact $contact)
    {
        $this->entityManager->remove($contact);
        $this->entityManager->flush($contact);
    }
}
