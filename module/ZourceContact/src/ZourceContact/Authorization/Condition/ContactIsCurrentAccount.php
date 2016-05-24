<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceContact\Authorization\Condition;

use Zend\View\Renderer\PhpRenderer;
use ZourceApplication\Authorization\Condition\AbstractCondition;
use ZourceUser\Authentication\AuthenticationService;

/**
 * A condition that checks if a the contact on the active page is the current authenticated user.
 */
class ContactIsCurrentAccount extends AbstractCondition
{
    /**
     * @var PhpRenderer
     */
    private $renderer;

    private $authenticationService;

    public function __construct(PhpRenderer $renderer, AuthenticationService $authenticationService)
    {
        $this->renderer = $renderer;
        $this->authenticationService = $authenticationService;
    }

    public function isValid()
    {
        $account = $this->authenticationService->getAccountEntity();

        return $account->getContact()->getId()->toString() !== $this->getContact()->getId()->toString();
    }

    private function getContact()
    {
        $viewModel = $this->renderer->viewModel()->getCurrent();
        $viewModelChildren = $viewModel->getChildren();
        $pageModel = $viewModelChildren[0];

        $company = $pageModel->getVariable('company');
        if ($company !== null) {
            return $company;
        }

        $person = $pageModel->getVariable('person');
        if ($person !== null) {
            return $person;
        }

        return null;
    }
}
