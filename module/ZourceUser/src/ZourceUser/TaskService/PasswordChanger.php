<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\TaskService;

use Doctrine\ORM\EntityManager;
use Zend\Crypt\Password\PasswordInterface;
use ZourceUser\V1\Rest\Account\AccountEntity;

class PasswordChanger
{
    private $entityManager;
    private $crypter;

    public function __construct(EntityManager $entityManager, PasswordInterface $crypter)
    {
        $this->entityManager = $entityManager;
        $this->crypter = $crypter;
    }

    public function changePassword(AccountEntity $account, $newPassword)
    {
        $credential = $this->crypter->create($newPassword);

        $account->setCredential($credential);

        $this->entityManager->persist($account);
        $this->entityManager->flush($account);
    }
}
