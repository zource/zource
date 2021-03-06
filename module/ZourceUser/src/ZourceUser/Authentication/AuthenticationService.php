<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Authentication;

use Doctrine\ORM\EntityManager;
use Zend\Authentication\Adapter;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\AuthenticationService as BaseAuthenticationService;
use Zend\Authentication\Storage\StorageInterface;
use ZourceUser\Entity\Account as AccountEntity;
use ZourceUser\Entity\Identity as IdentityEntity;

class AuthenticationService extends BaseAuthenticationService
{
    /**
     * The entity manager used to lookup
     *
     * @var EntityManager
     */
    private $entityManager;

    private $cachedAccount;
    private $cachedIdentity;

    public function __construct(EntityManager $entityManager, StorageInterface $storage, AdapterInterface $adapter)
    {
        parent::__construct($storage, $adapter);

        $this->entityManager = $entityManager;
    }

    public function getAdapter()
    {
        return $this->adapter;
    }

    public function clearIdentity()
    {
        $this->cachedIdentity = null;
        $this->cachedAccount = null;

        return parent::clearIdentity();
    }


    public function getIdentityEntity()
    {
        if (!$this->cachedIdentity && $this->hasIdentity()) {
            $identity = $this->entityManager->getRepository(IdentityEntity::class)->find($this->getIdentity());

            $this->cachedIdentity = $identity;
        }

        return $this->cachedIdentity;
    }

    public function getAccountEntity()
    {
        if (!$this->cachedAccount) {
            $identity = $this->getIdentityEntity();

            if ($identity) {
                $this->cachedAccount = $identity->getAccount();
            }
        }

        return $this->cachedAccount;
    }
}
