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

    public function findContact($type, $id)
    {
        switch ($type) {
            case ContactEntry::TYPE_COMPANY:
                $contact = $this->findCompany($id);
                break;

            case ContactEntry::TYPE_PERSON:
                $contact = $this->findPerson($id);
                break;

            default:
                throw new RuntimeException('Invalid type provided.');
        }

        return $contact;

    }

    public function findCompany($id)
    {
        $repository = $this->entityManager->getRepository(Company::class);

        return $repository->find($id);
    }

    public function findPerson($id)
    {
        $repository = $this->entityManager->getRepository(Person::class);

        return $repository->find($id);
    }

    public function getOverviewPaginator($filter)
    {
        $adapter = new ContactOverview($this->entityManager->getConnection(), $filter);

        return new Paginator($adapter);
    }

    public function createCompany(array $data)
    {
        $company = new Company($data['name']);

        $this->entityManager->persist($company);
        $this->entityManager->flush($company);

        return $company;
    }

    public function createPerson(array $data)
    {
        $person = new Person($data['name'], $data['familyName']);

        $this->entityManager->persist($person);
        $this->entityManager->flush($person);

        return $person;
    }

    public function deleteContact(AbstractContact $contact)
    {
        $this->entityManager->remove($contact);
        $this->entityManager->flush($contact);
    }
}
