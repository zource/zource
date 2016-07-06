<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Authentication\Adapter;

use Doctrine\ORM\EntityManager;
use Zend\Authentication\Adapter\ValidatableAdapterInterface;
use Zend\Authentication\Result;
use Zend\Crypt\Password\PasswordInterface;
use ZourceUser\Entity\Account;
use ZourceUser\Entity\Identity as IdentityEntity;

class Zource implements ValidatableAdapterInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var PasswordInterface
     */
    private $crypter;

    /**
     * @var string
     */
    private $identity;

    /**
     * @var string
     */
    private $credential;

    /**
     * @var string
     */
    private $directory;

    public function __construct(EntityManager $entityManager, $directory, PasswordInterface $crypter)
    {
        $this->entityManager = $entityManager;
        $this->crypter = $crypter;
        $this->directory = $directory;
    }

    /**
     * @return string
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * @param string $identity
     */
    public function setIdentity($identity)
    {
        $this->identity = $identity;
    }

    /**
     * @return string
     */
    public function getCredential()
    {
        return $this->credential;
    }

    /**
     * @param string $credential
     */
    public function setCredential($credential)
    {
        $this->credential = $credential;
    }

    /**
     * @return string
     */
    public function getDirectory()
    {
        return $this->directory;
    }

    /**
     * @param string $directory
     */
    public function setDirectory($directory)
    {
        $this->directory = $directory;
    }

    public function authenticate()
    {
        $repository = $this->entityManager->getRepository(IdentityEntity::class);
        $identity = $repository->findOneBy([
            'directory' => $this->directory,
            'identity' => $this->getIdentity(),
        ]);

        if (!$identity) {
            return new Result(Result::FAILURE_IDENTITY_NOT_FOUND, $this->getIdentity());
        }

        /** @var Account $account */
        $account = $identity->getAccount();

        if (!$this->crypter->verify($this->getCredential(), $account->getCredential())) {
            return new Result(Result::FAILURE_CREDENTIAL_INVALID, $this->getIdentity());
        }

        if ($account->getStatus() !== Account::STATUS_ACTIVE) {
            return new Result(Result::FAILURE_UNCATEGORIZED, $this->getIdentity(), [
                'The account has been deactivated.'
            ]);
        }

        return new Result(Result::SUCCESS, $identity->getId()->toString());
    }
}
