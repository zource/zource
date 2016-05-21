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
use ZourceUser\Entity\Identity as IdentityEntity;

class IdentityNotExists extends AbstractValidator
{
    const IDENTITY_EXISTS = 'identityExists';
    const DIRECTORY_MISSING = 'directoryMissing';

    /**
     * @var array
     */
    protected $messageTemplates = [
        self::IDENTITY_EXISTS => 'The identity already exists.',
        self::DIRECTORY_MISSING => 'The directory is missing.',
    ];

    /**
     * @var EntityManager
     */
    private $entityManager;

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
     * {@inheritDoc}
     */
    public function isValid($value, $context = null)
    {
        $directory = $context['directory'];
        if (!$directory) {
            $this->error(self::DIRECTORY_MISSING);
            return false;
        }

        $repository = $this->entityManager->getRepository(IdentityEntity::class);

        $qb = $repository->createQueryBuilder('i');
        $qb->select('count(i.account)');
        $qb->where($qb->expr()->eq('i.identity', ':identity'));
        $qb->andWhere($qb->expr()->eq('i.directory', ':directory'));
        $qb->setParameter(':directory', $directory);
        $qb->setParameter(':identity', $value);

        if ($qb->getQuery()->getSingleScalarResult() == 0) {
            return true;
        }

        $this->error(self::IDENTITY_EXISTS);

        return false;
    }
}
