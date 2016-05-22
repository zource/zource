<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\Session;

use DateTime;
use Doctrine\ORM\EntityManager;
use Zend\Http\PhpEnvironment\RemoteAddress;
use Zend\Session\SaveHandler\SaveHandlerInterface;
use ZourceApplication\Entity\Session;

class SaveHandler implements SaveHandlerInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $lifetime;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function open($savePath, $name)
    {
        $this->name = $name;
        $this->lifetime = (int)ini_get('session.gc_maxlifetime');

        return true;
    }

    public function close()
    {
        return true;
    }

    public function destroy($sessionId)
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->delete(Session::class, 's');
        $qb->where($qb->expr()->eq('s.id', ':id'));
        $qb->setParameter(':id', $sessionId);
        $qb->getQuery()->execute();
    }

    public function gc($maxlifetime)
    {
        $date = new DateTime();
        $date->setTimestamp($date->getTimestamp() - $maxlifetime);

        $qb = $this->entityManager->createQueryBuilder();
        $qb->delete(Session::class, 's');
        $qb->where($qb->expr()->lt('s.lastModified', ':date'));
        $qb->setParameter(':date', $date);
        $qb->getQuery()->execute();
    }

    public function read($sessionId)
    {
        $repository = $this->entityManager->getRepository(Session::class);

        /** @var Session $session */
        $session = $repository->find($sessionId);

        return $session ? $session->getData() : '';
    }

    public function write($id, $data)
    {
        $repository = $this->entityManager->getRepository(Session::class);
        $session = $repository->find($id);

        if (!$session) {
            $session = new Session($id, $this->getUserAgent(), $this->getRemoteAddress());
        }

        $session->setData($data);
        $session->setLastModified(new DateTime());
        $session->setLifetime($this->lifetime);

        $this->entityManager->persist($session);
        $this->entityManager->flush($session);

        return true;
    }

    private function getUserAgent()
    {
        return isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null;
    }

    private function getRemoteAddress()
    {
        $remoteAddress = new RemoteAddress();

        return $remoteAddress->getIpAddress();
    }
}
