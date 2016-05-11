<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Mvc\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZourceApplication\TaskService\RemoteAddressLookup;
use ZourceUser\Authentication\AuthenticationService;

class Security extends AbstractActionController
{
    private $authenticationService;
    private $remoteAddressLookup;

    public function __construct(
        AuthenticationService $authenticationService,
        RemoteAddressLookup $remoteAddressLookup
    ) {
        $this->authenticationService = $authenticationService;
        $this->remoteAddressLookup = $remoteAddressLookup;
    }

    public function indexAction()
    {
        return new ViewModel([
            'account' => $this->authenticationService->getAccountEntity(),
            'remoteAddressLookup' => $this->remoteAddressLookup,
        ]);
    }
}
