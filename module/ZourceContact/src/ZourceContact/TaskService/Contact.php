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

    public function populateApiArray($item)
    {
        $data = [
            'id' => $item->getId(),
            'type' => null,
            'creation_date' => $this->extractDate($item->getCreationDate()),
            'update_date' => $this->extractDate($item->getLastUpdated()),
            'display_name' => $item->getDisplayName(),
            'notes' => $item->getNotes(),
            'dates' => [],
            'email_addresses' => [],
            'impp_addresses' => [],
            'phone_numbers' => [],
            'properties' => [],
        ];

        /** @var Date $date */
        foreach ($item->getDates() as $date) {
            $data['email_addresses'] = $this->extractAbstractValue($date);
        }

        /** @var EmailAddress $emailAddress */
        foreach ($item->getEmailAddresses() as $emailAddress) {
            $data['email_addresses'] = $this->extractAbstractValue($emailAddress);
        }

        /** @var Impp $imppAddress */
        foreach ($item->getImppAddresses() as $imppAddress) {
            $data['impp_addresses'] = $this->extractAbstractValue($emailAddress);
        }

        /** @var PhoneNumber $phoneNumber */
        foreach ($item->getPhoneNumbers() as $phoneNumber) {
            $data['phone_numbers'] = $this->extractAbstractValue($emailAddress);
        }

        /** @var Property $property */
        foreach ($item->getProperties() as $property) {
            $data['properties'] = $this->extractAbstractValue($emailAddress);
        }

        if ($item instanceof Company) {
            $this->extractCompany($item, $data);
        } else {
            $this->extractPerson($item, $data);
        }

        return $data;
    }

    private function extractCompany(Company $item, array &$data)
    {
        $data['type'] = 'company';
        $data['name'] = $item->getName();
    }

    private function extractPerson(Person $item, array &$data)
    {
        $data['type'] = 'person';

        $data['gender'] = $item->getGender();

        $data['first_name'] = $item->getFirstName();
        $data['phonetic_first_name'] = $item->getPhoneticFirstName();

        $data['middle_name'] = $item->getMiddleName();
        $data['phonetic_middle_name'] = $item->getPhoneticMiddleName();

        $data['last_name'] = $item->getLastName();
        $data['phonetic_last_name'] = $item->getPhoneticLastName();

        $data['maiden_name'] = $item->getMaidenName();
        $data['suffix'] = $item->getSuffix();
        $data['nickname'] = $item->getNickname();
        $data['job_title'] = $item->getJobTitle();
        $data['department'] = $item->getDepartment();
        $data['company'] = $item->getCompany();
    }

    private function extractDate(\DateTime $date)
    {
        $date->setTimezone(new \DateTimeZone("UTC"));

        return $date->format('c');
    }

    private function extractAbstractValue(AbstractValue $value)
    {
        return [
            'id' => $value->getId(),
            'creation_date' => $this->extractDate($value->getCreationDate()),
            'type' => $value->getType(),
            'value' => $value->getValue(),
        ];
    }
}
