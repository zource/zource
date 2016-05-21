<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Validator;

use Doctrine\ORM\EntityManager;
use Zend\Validator\AbstractValidator;
use ZourceUser\Authentication\AuthenticationService;
use ZourceUser\Entity\Email;

class VerifyEmailCode extends AbstractValidator
{
    const INVALID_CODE = 'identityExists';

    /**
     * @var array
     */
    protected $messageTemplates = [
        self::INVALID_CODE => 'The code you have entered is invalid.',
    ];

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var AuthenticationService
     */
    private $authenticationService;

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param EntityManager $entityManager
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return AuthenticationService
     */
    public function getAuthenticationService()
    {
        return $this->authenticationService;
    }

    /**
     * @param AuthenticationService $authenticationService
     */
    public function setAuthenticationService(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    /**
     * {@inheritDoc}
     */
    public function isValid($value, $context = null)
    {
        $account = $this->getAuthenticationService()->getAccountEntity();
        $repository = $this->getEntityManager()->getRepository(Email::class);

        $qb = $repository->createQueryBuilder('e');
        $qb->select('COUNT(e) AS amount');
        $qb->where($qb->expr()->eq('e.validationCode', ':code'));
        $qb->andWhere($qb->expr()->eq('e.account', ':account'));
        $qb->setParameter(':code', $value);
        $qb->setParameter(':account', $account->getId()->getBytes());

        if ($qb->getQuery()->getSingleScalarResult() == 0) {
            $this->error(self::INVALID_CODE);
            return false;
        }

        return true;
    }
}
