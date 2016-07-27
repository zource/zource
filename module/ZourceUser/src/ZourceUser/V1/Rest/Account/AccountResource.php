<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\V1\Rest\Account;

use Doctrine\ORM\EntityManager;
use DoctrineModule\Paginator\Adapter\Selectable;
use Zend\Paginator\Adapter\Callback;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;
use ZourceContact\Entity\Company;
use ZourceUser\Entity\Account;

class AccountResource extends AbstractResourceListener
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * Initializes a new instance of this class.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function fetch($id)
    {
        /** @var Account $entity */
        $entity = $this->entityManager->find(Account::class, $id);

        if (!$entity) {
            return null;
        }

        return new AccountEntity($entity);
    }

    public function fetchAll($params = array())
    {
        $repository = $this->entityManager->getRepository(Account::class);

        $adapter = new Selectable($repository);

        return new AccountCollection($adapter);
    }
}
