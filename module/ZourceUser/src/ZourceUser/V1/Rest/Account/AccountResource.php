<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\V1\Rest\Account;

use Doctrine\ORM\EntityManager;
use Zend\Paginator\Adapter\Callback;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;
use ZourceContact\Entity\Company;
use ZourceUser\Entity\Account;

class AccountResource extends AbstractResourceListener
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * Initializes a new instance of this class.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        return new ApiProblem(405, 'The POST method has not been defined');
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for individual resources');
    }

    /**
     * Delete a collection, or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function deleteList($data)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for collections');
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        /** @var Account $entity */
        $entity = $this->entityManager->find(Account::class, $id);

        if (!$entity) {
            return null;
        }

        $result = new AccountEntity();
        $result->id = $entity->getId();
        $result->creationDate = $entity->getCreationDate();
        $result->status = $entity->getStatus();
        $result->contactId = $entity->getContact()->getId();
        $result->contactType = $entity->getContact() instanceof Company ? 'company' : 'person';

        return $result;
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = array())
    {
        $adapter = new Callback(
            function($offset, $itemCountPerPage) {
                $qb = $this->entityManager->createQueryBuilder();
                $qb->select('e, c');
                $qb->from(Account::class, 'e');
                $qb->join('e.contact', 'c');
                $qb->setFirstResult($offset);
                $qb->setMaxResults($itemCountPerPage);

                $result = [];

                foreach ($qb->getQuery()->getArrayResult() as $item) {
                    $result[] = [
                        'id' => $item['id'],
                        'creation_date' => $item['creationDate'],
                        'status' => $item['status'],
                        'contact_id' => $item['contact']['id'],
                        'contact' => [
                            'type' => $item['contact']['contact_type'],
                            'id' => $item['contact']['id'],
                        ],
                    ];
                }

                return $result;
            },
            function() {
                $qb = $this->entityManager->createQueryBuilder();
                $qb->select('COUNT(e)');
                $qb->from(Account::class, 'e');

                return $qb->getQuery()->getSingleScalarResult();
            }
        );

        return new AccountCollection($adapter);
    }

    /**
     * Patch (partial in-place update) a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for individual resources');
    }

    /**
     * Replace a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function replaceList($data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for collections');
    }

    /**
     * Update a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for individual resources');
    }
}
