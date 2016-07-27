<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\V1\Rest\Session;

use Doctrine\ORM\EntityManager;
use DoctrineModule\Paginator\Adapter\Selectable;
use ZF\Rest\AbstractResourceListener;
use ZourceApplication\Entity\Session;

class SessionResource extends AbstractResourceListener
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function fetch($id)
    {
        $repository = $this->entityManager->getRepository(Session::class);
        $session = $repository->find($id);

        if (!$session) {
            return null;
        }

        $entity = new SessionEntity();
        $entity->sessionId = $session->getId();
        $entity->creationDate = $session->getCreationDate();
        $entity->lastModified = $session->getLastModified();
        $entity->lifetime = $session->getLifetime();
        $entity->userAgent = $session->getUserAgent();
        $entity->remoteAddress = $session->getRemoteAddress();

        return $entity;
    }

    public function fetchAll($params = [])
    {
        $repository = $this->entityManager->getRepository(Session::class);

        $adapter = new Selectable($repository);

        return new SessionCollection($adapter);
    }
}
