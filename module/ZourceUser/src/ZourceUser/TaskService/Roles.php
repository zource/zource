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
use Zend\Crypt\Password\PasswordInterface;
use Zend\Math\Rand;
use Zend\Paginator\Paginator;
use ZourceUser\Entity\OAuthApplication;
use ZourceUser\Entity\AccountInterface;
use ZourceUser\Entity\Role;

class Roles
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function find($id)
    {
        $repository = $this->entityManager->getRepository(Role::class);

        return $repository->find($id);
    }

    public function remove(Role $role)
    {
        $this->entityManager->remove($role);
        $this->entityManager->flush($role);
    }

    public function persist(Role $role)
    {
        $this->entityManager->persist($role);
        $this->entityManager->flush($role);
    }

    public function persistFromArray(array $data)
    {
        $role = new Role($data['name']);

        return $this->persist($role);
    }

    public function getPaginator()
    {
        $repository = $this->entityManager->getRepository(Role::class);
        $adapter = new Selectable($repository);

        return new Paginator($adapter);
    }
}
