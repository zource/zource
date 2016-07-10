<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Authorization\Condition;

use Zend\Authentication\AuthenticationService;
use Zend\Permissions\Rbac\Rbac;
use ZourceApplication\Authorization\Condition\AbstractCondition;

/**
 * A condition that checks if the current authenticated account has access.
 */
class UserHasAccess extends AbstractCondition
{
    /**
     * @var AuthenticationService
     */
    private $authenticationService;

    /**
     * @var Rbac
     */
    private $authorizationService;

    /**
     * @var string
     */
    private $resource;

    /**
     * @var string
     */
    private $permission;

    public function __construct(
        AuthenticationService $authenticationService,
        Rbac $authorizationService,
        $resource,
        $permission
    ) {
        $this->authenticationService = $authenticationService;
        $this->authorizationService = $authorizationService;
        $this->resource = $resource;
        $this->permission = $permission;
    }

    public function isValid()
    {
        $account = $this->authenticationService->getAccountEntity();
        if (!$account) {
            return false;
        }

        $permission = $this->resource . '.' . $this->permission;

        return $this->authorizationService->isGranted('account-' . $account->getId()->toString(), $permission);
    }
}
