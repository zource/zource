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
use Zend\Authentication\Adapter\AbstractAdapter;
use Zend\Authentication\Adapter\Ldap as ZendLdapAdapter;
use Zend\Authentication\Result;

class Ldap extends AbstractAdapter
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var array
     */
    private $options;

    public function __construct(EntityManager $entityManager, array $options)
    {
        $this->entityManager = $entityManager;
        $this->options = $options;
    }

    public function authenticate()
    {
        $ldapAdapter = new ZendLdapAdapter($this->options, $this->getIdentity(), $this->getCredential());

        $result = $ldapAdapter->authenticate();

        if (!$result->isValid()) {
            return $result;
        }

        $zourceAdapter = new Zource($this->entityManager, 'ldap', null);
        $zourceAdapter->setIdentity($result->getIdentity());

        return $zourceAdapter->authenticate();
    }
}
