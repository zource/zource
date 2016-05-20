<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Mvc\Controller;

use Base32\Base32;
use Zend\Http\Response\Stream;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZourceApplication\TaskService\Session;
use ZourceUser\Authentication\AuthenticationService;

class Security extends AbstractActionController
{
    /**
     * @var AuthenticationService
     */
    private $authenticationService;

    /**
     * @var Session
     */
    private $sessionService;

    public function __construct(AuthenticationService $authenticationService, Session $sessionService)
    {
        $this->authenticationService = $authenticationService;
        $this->sessionService = $sessionService;
    }

    public function indexAction()
    {
        $account = $this->authenticationService->getAccountInterface();
        
        return new ViewModel([
            'account' => $account,
            'remoteAddressLookup' => $this->sessionService->getRemoteAddressLookup(),
            'sessions' => $this->sessionService->getForAccount($account),
            'userAgentParser' => $this->sessionService->getUserAgentParser(),
        ]);
    }

    public function revokeSessionAction()
    {
        $session = $this->sessionService->getSession($this->params('id'));

        if (!$session) {
            return $this->notFoundAction();
        }

        if ($this->zourceAccount() !== $session->getAccount()) {
            return $this->notFoundAction();
        }

        $this->sessionService->deleteSession($session);

        return $this->redirect()->toRoute('settings/security');
    }
}
