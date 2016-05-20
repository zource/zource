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
use Ramsey\Uuid\UuidInterface;
use Zend\Authentication\Adapter\ValidatableAdapterInterface;
use Zend\Authentication\Result;
use Zend\Crypt\Password\Bcrypt;
use Zend\Crypt\Password\PasswordInterface;
use ZourceUser\Entity\AccountInterface;
use ZourceUser\V1\Rest\Identity\IdentityEntity;

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
            'directory' => $this->getDirectory(),
            'identity' => $this->getIdentity(),
        ]);

        if (!$identity) {
            return new Result(Result::FAILURE_IDENTITY_NOT_FOUND, $this->getIdentity());
        }

        $credential = $identity->getAccount()->getCredential();

        if (!$this->crypter->verify($this->getCredential(), $credential)) {
            return new Result(Result::FAILURE_CREDENTIAL_INVALID, $this->getIdentity());
        }

        return new Result(Result::SUCCESS, $identity->getId()->toString());
    }
}
