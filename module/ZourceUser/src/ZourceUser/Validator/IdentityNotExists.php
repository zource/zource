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
     * @var array
     */
    protected $options = [
        'directory' => null,
        'entity_manager' => null,
    ];

    /**
     * {@inheritDoc}
     */
    public function isValid($value, $context = null)
    {
        if (array_key_exists('directory', $context)) {
            $directory = $context['directory'];
        } else {
            $directory = $this->options['directory'];
        }

        if (!$directory) {
            $this->error(self::DIRECTORY_MISSING);
            return false;
        }

        $repository = $this->options['entity_manager']->getRepository(IdentityEntity::class);

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
