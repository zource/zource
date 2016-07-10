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
use DoctrineModule\Paginator\Adapter\Selectable;
use Zend\Crypt\Password\PasswordInterface;
use Zend\Math\Rand;
use Zend\Paginator\Paginator;
use ZourceUser\Entity\OAuthApplication;
use ZourceUser\Entity\AccountInterface;
use ZourceUser\Entity\Role;

class Permissions
{
    private $permissions;

    public function __construct($permissions)
    {
        $this->permissions = $permissions;

        ksort($this->permissions);
    }

    public function getPermissions()
    {

        return $this->permissions;
    }
}
