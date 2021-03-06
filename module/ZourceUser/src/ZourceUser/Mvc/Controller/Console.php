<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Mvc\Controller;

use Doctrine\ORM\EntityManager;
use Exception;
use Zend\Console\Prompt\Line;
use Zend\Console\Prompt\Password;
use Zend\Crypt\Password\PasswordInterface;
use Zend\Mvc\Controller\AbstractConsoleController;
use ZourceContact\Entity\Person;
use ZourceUser\Entity\Account;
use ZourceUser\Entity\AccountInterface;
use ZourceUser\Entity\Group;
use ZourceUser\Entity\Identity;
use ZourceUser\Entity\IdentityInterface;

class Console extends AbstractConsoleController
{
    private $config;
    private $entityManager;
    private $crypter;

    public function __construct(array $config, EntityManager $entityManager, PasswordInterface $crypter)
    {
        $this->config = $config;
        $this->entityManager = $entityManager;
        $this->crypter = $crypter;
    }

    public function accountCreateAction()
    {
        $firstName = $this->params('first-name');
        if (!$firstName) {
            $firstName = Line::prompt('Please enter the first name of the person: ');
        }

        $lastName = $this->params('last-name');
        if (!$lastName) {
            $lastName = Line::prompt('Please enter the last name of the person: ');
        }

        $credential = $this->params('credential');
        if (!$credential) {
            $credential = Password::prompt('Please enter the credential of this new account: ');
            $verification = Password::prompt('Please enter the credential again to verify: ');

            if ($credential !== $verification) {
                $this->getConsole()->writeLine('The two credentials do not match.');
                return 1;
            }
        }
        
        $person = new Person($firstName, $lastName);
        
        $account = new Account($person);
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
                    '%s - Created on: %s - %s',
                    $account->getId()->toString(),
                    $account->getCreationDate()->format('Y-m-d H:i:s'),
                    $account->getContact()->getDisplayName()
                ));
            }

            $page++;
        } while (count($accounts) !== 0);

        return 0;
    }

    public function groupCreateAction()
    {
        $name = $this->params('name');
        while (!$name) {
            $name = Line::prompt('Please enter the name of the group: ');
        }

        $group = new Group($name);

        $this->entityManager->persist($group);
        $this->entityManager->flush($group);

        $this->getConsole()->writeLine('Group created with id ' . $group->getId()->toString());
        return 0;
    }

    public function groupDeleteAction()
    {
        $group = $this->getGroup($this->params('id'));

        if (!$group) {
            $this->getConsole()->writeLine(sprintf('The group with id "%s" does not exists.', $this->params('id')));
            return 1;
        }

        $this->entityManager->remove($group);
        $this->entityManager->flush($group);

        $this->getConsole()->writeLine(sprintf('The group with id "%s" has been deleted.', $this->params('id')));
        return 0;
    }

    public function groupListAction()
    {
        $repository = $this->entityManager->getRepository(Group::class);

        $page = 1;
        $limit = 25;

        do {
            $offset = $page * $limit - $limit;

            $entities = $repository->findBy([], [], $limit, $offset);
            if (count($entities) === 0) {
                break;
            }

            /** @var Group $entity */
            foreach ($entities as $entity) {
                $this->getConsole()->writeLine(sprintf(
                    '%s - %s',
                    $entity->getId()->toString(),
                    $entity->getName()
                ));
            }

            $page++;
        } while (count($entities) !== 0);

        return 0;
    }

    public function groupPermissionAction()
    {
        $group = $this->getGroup($this->params('id'));

        if (!$group) {
            $this->getConsole()->writeLine(sprintf('The group with id "%s" does not exists.', $this->params('id')));
            return 1;
        }

        $allow = $this->params('allow') === true;
        $permission = $this->params('permission');
        $permissions = $group->getPermissions();

        if ($allow && $permission) {
            $permissions[] = $permission;
        } elseif ($allow) {
            $permissions = array_keys($this->config['zource_permissions']);
        } elseif (!$allow && $permission) {
            $index = array_search($permission, $permissions);

            unset($permissions[$index]);
        } elseif (!$allow) {
            $permissions = [];
        }

        $group->setPermissions($permissions);

        $this->entityManager->flush($group);

        $this->getConsole()->writeLine(sprintf('The group with id "%s" has been updated.', $this->params('id')));
        return 0;
    }

    public function groupMemberAction()
    {
        $group = $this->getGroup($this->params('id'));

        if (!$group) {
            $this->getConsole()->writeLine(sprintf('The group with id "%s" does not exists.', $this->params('id')));
            return 1;
        }

        $toAdd = $this->params('add');
        if ($toAdd) {
            $account = $this->getAccount($toAdd);
            if ($account) {
                $group->addAccount($account);
            }
        }

        $toRemove = $this->params('remove');
        if ($toRemove) {
            $account = $this->getAccount($toRemove);
            if ($account) {
                $group->removeAccount($account);
            }
        }

        $this->entityManager->flush($group);

        $this->getConsole()->writeLine(sprintf('The group with id "%s" has been updated.', $this->params('id')));
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
            $repository = $this->entityManager->getRepository(AccountInterface::class);

            $entity = $repository->find($id);
        } catch (Exception $e) {
            $entity = null;
        }

        return $entity;
    }

    /**
     * @param string $id
     * @return null|Group
     */
    private function getGroup($id)
    {
        try {
            $repository = $this->entityManager->getRepository(Group::class);

            $entity = $repository->find($id);
        } catch (Exception $e) {
            $entity = null;
        }

        return $entity;
    }
}
