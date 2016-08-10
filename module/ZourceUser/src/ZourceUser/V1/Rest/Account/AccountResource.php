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
use RuntimeException;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\Rest\AbstractResourceListener;
use ZourceContact\Entity\Person;
use ZourceUser\Entity\Account;
use ZourceUser\Entity\AccountInterface;

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

    public function create($data)
    {
        $person = new Person($data->first_name, $data->last_name);

        if (isset($data->middle_name)) {
            $person->setMiddleName($data->middle_name);
        }

        if (isset($data->display_name)) {
            $person->setDisplayName($data->display_name);
        }

        $account = new Account($person);

        switch ($data->status) {
            case 'active':
                $account->setStatus(AccountInterface::STATUS_ACTIVE);
                break;

            case 'inactive':
                $account->setStatus(AccountInterface::STATUS_INACTIVE);
                break;

            default:
                throw new RuntimeException('Invalid account status provided.');
        }

        $this->entityManager->persist($person);
        $this->entityManager->persist($account);
        $this->entityManager->flush($account);

        return new AccountEntity($account);
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

    public function patch($id, $data)
    {
        return $this->update($id, $data);
    }

    public function update($id, $data)
    {
        /** @var Account $entity */
        $entity = $this->entityManager->find(Account::class, $id);

        if (!$entity) {
            return new ApiProblem(ApiProblemResponse::STATUS_CODE_404, 'Entity not found.');
        }

        switch ($data->status) {
            case 'active':
                $entity->setStatus(AccountInterface::STATUS_ACTIVE);
                break;

            case 'inactive':
                $entity->setStatus(AccountInterface::STATUS_INACTIVE);
                break;

            default:
                throw new RuntimeException('Invalid account status provided.');
        }

        $this->entityManager->flush($entity);

        return new AccountEntity($entity);
    }
}
