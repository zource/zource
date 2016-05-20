<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\TaskService;

use Base32\Base32;
use Doctrine\ORM\EntityManager;
use Zend\Math\Rand;
use Zend\Session\Container;
use ZourceUser\V1\Rest\Account\AccountEntity;
use ZourceUser\V1\Rest\Email\EmailEntity;

class Email
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createFromArray(AccountEntity $account, array $data)
    {
        $isPrimary = $account->getEmailAddresses()->count() === 0;
        $validationCode = $this->generateValidationCode();

        $emailAddress = new EmailEntity($account, $data['emailAddress']);
        $emailAddress->setIsPrimary($isPrimary);
        $emailAddress->setValidationCode($validationCode);

        $this->entityManager->persist($emailAddress);
        $this->entityManager->flush($emailAddress);
    }

    public function getAddress(AccountEntity $account, $id)
    {
        $emailAddressesRepository = $this->entityManager->getRepository(EmailEntity::class);

        return $emailAddressesRepository->findOneBy([
            'account' => $account,
            'id' => $id,
        ]);
    }

    public function getAddressByCode(AccountEntity $account, $id, $code)
    {
        $emailAddressesRepository = $this->entityManager->getRepository(EmailEntity::class);

        return $emailAddressesRepository->findOneBy([
            'account' => $account,
            'id' => $id,
            'validationCode' => $code,
        ]);
    }

    public function makePrimary(AccountEntity $account, $id)
    {
        $emailAddressesRepository = $this->entityManager->getRepository(EmailEntity::class);

        $qb = $emailAddressesRepository->createQueryBuilder('e');
        $qb->update();
        $qb->set('e.isPrimary', ':isPrimary');
        $qb->where($qb->expr()->eq('e.account', ':account'));
        $qb->setParameter(':isPrimary', false);
        $qb->setParameter(':account', $account->getId()->getBytes());
        $qb->getQuery()->execute();

        $emailAddress = $this->getAddress($account, $id);
        $emailAddress->setIsPrimary(true);

        $this->entityManager->persist($emailAddress);
        $this->entityManager->flush($emailAddress);

        return $emailAddress;
    }

    public function activate(AccountEntity $account, $id, $code)
    {
        $emailAddress = $this->getAddressByCode($account, $id, $code);
        if (!$emailAddress) {
            return;
        }

        $emailAddress->setValidationCode(null);

        $this->entityManager->persist($emailAddress);
        $this->entityManager->flush($emailAddress);
    }

    public function delete(EmailEntity $emailAddress)
    {
        $this->entityManager->remove($emailAddress);
        $this->entityManager->flush($emailAddress);
    }

    public function getForAccount(AccountEntity $account)
    {
        $emailAddressesRepository = $this->entityManager->getRepository(EmailEntity::class);

        return $emailAddressesRepository->findBy([
            'account' => $account,
        ], [
            'address' => 'ASC',
        ]);
    }

    private function generateValidationCode()
    {
        $charList = [
            'abcdefghijklmnopqrstuvwxyz',
            'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
            '0123456789'
        ];

        return Rand::getString(32, implode('', $charList));
    }
}
