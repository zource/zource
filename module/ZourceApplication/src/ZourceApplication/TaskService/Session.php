<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\TaskService;

use Doctrine\ORM\EntityManager;
use ZourceApplication\Entity\Session as SessionEntity;
use ZourceUser\Entity\AccountInterface;

class Session
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var RemoteAddressLookup
     */
    private $remoteAddressLookup;

    public function __construct(EntityManager $entityManager, RemoteAddressLookup $remoteAddressLookup)
    {
        $this->entityManager = $entityManager;
        $this->remoteAddressLookup = $remoteAddressLookup;
    }

    /**
     * @return RemoteAddressLookup
     */
    public function getRemoteAddressLookup()
    {
        return $this->remoteAddressLookup;
    }

    public function getUserAgentParser()
    {
        $userAgentParser = \UAParser\Parser::create();

        return $userAgentParser;
    }

    public function getSession($id)
    {
        return $this->entityManager->getRepository(SessionEntity::class)->find($id);
    }

    public function deleteSession($id)
    {
        $repository = $this->entityManager->getRepository(SessionEntity::class);

        $qb = $repository->createQueryBuilder('s');
        $qb->delete();
        $qb->where($qb->expr()->eq('s.id', ':id'));
        $qb->setParameter(':id', $id);
        $qb->getQuery()->execute();
    }

    public function getForAccount(AccountInterface $account)
    {
        $repository = $this->entityManager->getRepository(SessionEntity::class);

        $qb = $repository->createQueryBuilder('s');
        $qb->select('s');
        $qb->where($qb->expr()->eq('s.account', ':account'));
        $qb->orderBy('s.lastModified', 'DESC');
        $qb->setParameter(':account', $account->getId()->getBytes());

        return $qb->getQuery()->getArrayResult();
    }
}
