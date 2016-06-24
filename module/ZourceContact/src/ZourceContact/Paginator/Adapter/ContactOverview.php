<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceContact\Paginator\Adapter;

use Doctrine\ORM\EntityManager;
use Zend\Paginator\Adapter\AdapterInterface;
use ZourceContact\Entity\AbstractContact;
use ZourceContact\Entity\Company;
use ZourceContact\Entity\Person;

class ContactOverview implements AdapterInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var string
     */
    private $filter;

    public function __construct(EntityManager $entityManager, $filter = null)
    {
        $this->entityManager = $entityManager;
        $this->filter = $filter;
    }

    public function getItems($offset, $itemCountPerPage)
    {
        $repository = $this->entityManager->getRepository(AbstractContact::class);

        $qb = $repository->createQueryBuilder('c');

        switch ($this->filter) {
            case 'company':
                $qb->where($qb->expr()->isInstanceOf('c', Company::class));
                break;

            case 'person':
                $qb->where($qb->expr()->isInstanceOf('c', Person::class));
                break;

            default:
                break;
        }

        $qb->orderBy('c.displayName', 'ASC');
        $qb->setFirstResult($offset);
        $qb->setMaxResults($itemCountPerPage);

        return $qb->getQuery()->getResult();
    }

    public function count()
    {
        $repository = $this->entityManager->getRepository(AbstractContact::class);

        $qb = $repository->createQueryBuilder('c');
        $qb->select('COUNT(c.id)');

        switch ($this->filter) {
            case 'company':
                $qb->where($qb->expr()->isInstanceOf('c', Company::class));
                break;

            case 'person':
                $qb->where($qb->expr()->isInstanceOf('c', Person::class));
                break;

            default:
                break;
        }

        return $qb->getQuery()->getSingleScalarResult();
    }
}
