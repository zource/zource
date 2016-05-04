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
use ZourceApplication\Authorization\Condition\AbstractCondition;

/**
 * A condition that checks if the current user has an identity.
 */
class UserHasIdentity extends AbstractCondition
{
    /**
     * @var AuthenticationService
     */
    private $authenticationService;

    public function __construct(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function isValid()
    {
        return $this->authenticationService->hasIdentity();
    }
}
