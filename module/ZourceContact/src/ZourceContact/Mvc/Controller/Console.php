<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceContact\Mvc\Controller;

use Doctrine\ORM\EntityManager;
use Exception;
use Zend\Console\Prompt\Password;
use Zend\Crypt\Password\PasswordInterface;
use Zend\Mvc\Controller\AbstractConsoleController;
use ZourceContact\Entity\Account;
use ZourceContact\Entity\AccountInterface;
use ZourceContact\Entity\Identity;
use ZourceContact\Entity\IdentityInterface;

class Console extends AbstractConsoleController
{
    private $entityManager;
    private $crypter;

    public function __construct(EntityManager $entityManager, PasswordInterface $crypter)
    {
        $this->entityManager = $entityManager;
        $this->crypter = $crypter;
    }

    public function accountCreateAction()
    {
        $credential = $this->params('credential');

        if (!$credential) {
            $credential = Password::prompt('Please enter the credential of this new account: ');
            $verification = Password::prompt('Please enter the credential again to verify: ');

            if ($credential !== $verification) {
                $this->getConsole()->writeLine('The two credentials do not match.');
                return 1;
            }
        }

        $account = new Account();
        $account->setCredential($this->crypter->create($credential));

        $this->entityManager->persist($account);
        $this->entityManager->flush($account);

        $this->getConsole()->writeLine('Account created with id ' . $account->getId()->toString());
        return 0;
    }

    public function accountDeleteAction()
    {
        $account = $this->getAccount($this->params('id'));

        if (!$account) {
            $this->getConsole()->writeLine(sprintf('The account with id "%s" does not exists.', $this->params('id')));
            return 1;
        }

        $this->entityManager->remove($account);
        $this->entityManager->flush($account);

        $this->getConsole()->writeLine(sprintf('The account with id "%s" has been deleted.', $this->params('id')));
        return 0;
    }

    public function accountListAction()
    {
        $accountRepository = $this->entityManager->getRepository(AccountInterface::class);

        $page = 1;
        $limit = 25;

        do {
            $offset = $page * $limit - $limit;
            
            $accounts = $accountRepository->findBy([], [], $limit, $offset);
            if (count($accounts) === 0) {
                break;
            }
            
            /** @var AccountInterface $account */
            foreach ($accounts as $account) {
                $this->getConsole()->writeLine(sprintf(
                    '%s - Created on: %s',
                    $account->getId()->toString(),
                    $account->getCreationDate()->format('Y-m-d H:i:s')
                ));
            }

            $page++;
        } while (count($accounts) !== 0);

        return 0;
    }

    public function identityCreateAction()
    {
        $account = $this->getAccount($this->params('account'));
        if (!$account) {
            $this->getConsole()->writeLine(sprintf('The account with id "%s" could not be found.', $this->params('account')));
            return 1;
        }

        $identity = new Identity($account, $this->params('directory'), $this->params('identity'));

        $this->entityManager->persist($identity);
        $this->entityManager->flush($identity);

        $this->getConsole()->writeLine('Identity created with id ' . $identity->getId()->toString());
        return 0;
    }

    public function identityDeleteAction()
    {
        try {
            $identityRepository = $this->entityManager->getRepository(IdentityInterface::class);
            $identity = $identityRepository->find($this->params('id'));
        } catch (Exception $e) {
            $identity = null;
        }

        if (!$identity) {
            $this->getConsole()->writeLine(sprintf('The identity with id "%s" does not exists.', $this->params('id')));
            return 1;
        }

        $this->entityManager->remove($identity);
        $this->entityManager->flush($identity);

        $this->getConsole()->writeLine(sprintf('The identity with id "%s" has been deleted.', $this->params('id')));
        return 0;
    }

    private function getAccount($id)
    {
        try {
            $accountRepository = $this->entityManager->getRepository(AccountInterface::class);

            $account = $accountRepository->find($id);
        } catch (Exception $e) {
            $account = null;
        }

        return $account;
    }
}
