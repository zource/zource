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
use Ramsey\Uuid\Uuid;
use RuntimeException;
use Zend\Paginator\Adapter\Callback;
use Zend\Paginator\Paginator;
use ZourceContact\Entity\Company;
use ZourceContact\Entity\Person;
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
            case 'company':
                $contact = $this->findCompany($id);
                break;

            case 'person':
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

    public function getFilterPaginator($filterName)
    {
        return $this->getOverviewPaginator();
    }

    public function getOverviewPaginator()
    {
        $personSql = "SELECT 'person' AS type, id, CONCAT_WS(' ', name, family_name) AS display_name FROM contact_person";
        $companySql = "SELECT 'company' AS type, id, name AS display_name FROM contact_company";
        $unionSql = $personSql . ' UNION ' . $companySql;

        $itemCallback = function ($offset, $itemCountPerPage) use ($unionSql) {
            $unionSql .= " ORDER BY display_name ASC";
            $unionSql .= sprintf(" LIMIT %d, %d", $offset, $itemCountPerPage);

            $statement = $this->entityManager->getConnection()->executeQuery($unionSql);
            $result = $statement->fetchAll();

            return array_map(function ($item) {
                return new ContactEntry(
                    $item['type'],
                    Uuid::fromBytes($item['id']),
                    $item['display_name']
                );
            }, $result);
        };

        $countCallback = function () use ($unionSql) {
            $countSql = "SELECT COUNT(1) AS amount FROM (" . $unionSql . ") AS c";

            $statement = $this->entityManager->getConnection()->executeQuery($countSql);

            return $statement->fetchColumn();
        };

        return new Paginator(new Callback($itemCallback, $countCallback));
    }
}
