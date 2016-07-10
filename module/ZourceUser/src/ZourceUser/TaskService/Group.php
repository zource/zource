<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\TaskService;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Paginator\Adapter\Selectable;
use Zend\Paginator\Paginator;
use ZourceUser\Entity\Group as GroupEntity;

class Group
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function find($id)
    {
        $repository = $this->entityManager->getRepository(GroupEntity::class);

        return $repository->find($id);
    }

    public function remove(GroupEntity $group)
    {
        $this->entityManager->remove($group);
        $this->entityManager->flush($group);
    }

    public function persist(GroupEntity $group)
    {
        $this->entityManager->persist($group);
        $this->entityManager->flush($group);
    }

    public function getPaginator()
    {
        $criteria = Criteria::create();
        $criteria->orderBy([
            'name' => Criteria::ASC,
        ]);
        $repository = $this->entityManager->getRepository(GroupEntity::class);
        $adapter = new Selectable($repository, $criteria);

        return new Paginator($adapter);
    }

    public function lookup($queryTerm)
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select(['g.id', 'g.name']);
        $qb->from(GroupEntity::class, 'g');
        $qb->where($qb->expr()->like('g.name', ':query'));
        $qb->orderBy('g.name', 'ASC');
        $qb->setParameter(':query', '%' . $queryTerm . '%');

        $result = [];

        foreach ($qb->getQuery()->getResult() as $entry) {
            $result[] = [
                'id' => $entry['id']->toString(),
                'text' => $entry['name'],
            ];
        }

        return [
            'items' => $result,
        ];
    }
}
