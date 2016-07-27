<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\V1\Rest\Group;

use Doctrine\ORM\EntityManager;
use DoctrineModule\Paginator\Adapter\Selectable;
use ZF\Rest\AbstractResourceListener;
use ZourceUser\Entity\Group;

class GroupResource extends AbstractResourceListener
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function fetch($id)
    {
        $repository = $this->entityManager->getRepository(Group::class);
        $group = $repository->find($id);

        if (!$group) {
            return null;
        }

        $entity = new GroupEntity();
        $entity->id = $group->getId();
        $entity->name = $group->getName();

        return $entity;
    }

    public function fetchAll($params = [])
    {
        $repository = $this->entityManager->getRepository(Group::class);

        $adapter = new Selectable($repository);

        return new GroupCollection($adapter);
    }
}
