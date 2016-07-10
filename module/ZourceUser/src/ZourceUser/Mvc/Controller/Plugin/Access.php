<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Mvc\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Permissions\Rbac\Rbac;
use ZourceUser\Authentication\AuthenticationService;
use ZourceUser\Entity\AccountInterface;

class Access extends AbstractPlugin
{
    /**
     * @var Rbac
     */
    private $authorizationService;

    /**
     * @var AuthenticationService
     */
    private $authenticationService;

    public function __construct(Rbac $authorizationService, AuthenticationService $authenticationService)
    {
        $this->authorizationService = $authorizationService;
        $this->authenticationService = $authenticationService;
    }

    public function __invoke($permission, $assert = null, AccountInterface $account = null)
    {
        if ($account === null) {
            $account = $this->authenticationService->getAccountEntity();
        }

        //$groups = $account->getGroups();
        //var_dump($groups->count());
        //exit;

        return $this->authorizationService->isGranted(
            'account-' . $account->getId()->toString(),
            $permission,
            $assert
        );
    }
}
