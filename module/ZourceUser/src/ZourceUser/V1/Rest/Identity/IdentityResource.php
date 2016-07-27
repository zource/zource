<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\V1\Rest\Identity;

use Doctrine\ORM\EntityManager;
use DoctrineModule\Paginator\Adapter\Selectable;
use ZF\Rest\AbstractResourceListener;
use ZourceUser\Entity\Identity;

class IdentityResource extends AbstractResourceListener
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function fetch($id)
    {
        $repository = $this->entityManager->getRepository(Identity::class);
        $identity = $repository->find($id);

        if (!$identity) {
            return null;
        }

        return new IdentityEntity($identity);
    }

    public function fetchAll($params = [])
    {
        $repository = $this->entityManager->getRepository(Identity::class);

        $adapter = new Selectable($repository);

        return new IdentityCollection($adapter);
    }
}
