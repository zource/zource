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
        $role = new Role($data['name']);

        return $this->persist($role);
    }

    public function getPaginator()
    {
        $repository = $this->entityManager->getRepository(GroupEntity::class);
        $adapter = new Selectable($repository);

        return new Paginator($adapter);
    }
}
