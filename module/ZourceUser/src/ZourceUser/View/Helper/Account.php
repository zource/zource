<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\View\Helper;

use Zend\View\Helper\AbstractHelper;
use ZourceUser\Authentication\AuthenticationService;

class Account extends AbstractHelper
{
    /**
     * @var AuthenticationService
     */
    private $authService;

    public function __construct(AuthenticationService $authService)
    {
        $this->authService = $authService;
    }

    public function __invoke()
    {
        return $this->authService->getAccountEntity();
    }
}
