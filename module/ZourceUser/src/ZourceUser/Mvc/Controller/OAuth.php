<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Mvc\Controller;

use Ramsey\Uuid\Uuid;
use Zend\Authentication\AuthenticationService;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use ZourceUser\TaskService\OAuth as OAuthTaskService;

class OAuth extends AbstractActionController
{
    /**
     * @var OAuthTaskService
     */
    private $oauthServer;

    /**
     * @var AuthenticationService
     */
    private $authenticationService;

    public function __construct(OAuthTaskService $oauthServer, AuthenticationService $authenticationService)
    {
        $this->oauthServer = $oauthServer;
        $this->authenticationService = $authenticationService;
    }

    public function authorizeAction()
    {
        $request = $this->getRequest();

        if (!$request instanceof Request || $request->isOptions()) {
            return $this->getResponse();
        }

        $application = $this->oauthServer->getApplication($this->getRequest()->getQuery('client_id'));
        if (!$application) {
            return $this->oauthServer->handleAuthorizeRequest(
                $request,
                $this->getResponse(),
                false,
                $this->authenticationService->getIdentity()
            );
        }

        if ($this->oauthServer->isApplicationAuthorized($application, $this->authenticationService->getIdentity())) {
            return $this->oauthServer->handleAuthorizeRequest(
                $request,
                $this->getResponse(),
                true,
                $this->authenticationService->getIdentity()
            );
        }

        $isAllowed = $this->getRequest()->getPost('allow') !== null;
        $isDenied = $this->getRequest()->getPost('deny') !== null;

        if (!$this->getRequest()->isPost() || (!$isAllowed && !$isDenied)) {
            return new ViewModel([
                'application' => $application,
            ]);
        }

        $this->oauthServer->authorizeApplication(
            $application,
            $this->authenticationService->getIdentity()
        );

        return $this->oauthServer->handleAuthorizeRequest(
            $request,
            $this->getResponse(),
            $isAllowed,
            $this->authenticationService->getIdentity()
        );
    }

    public function tokenAction()
    {
        $request = $this->getRequest();

        if (!$request instanceof Request || $request->isOptions()) {
            return $this->getResponse();
        }

        return $this->oauthServer->handleTokenRequest($request, $this->getResponse());
    }

    public function resourceAction()
    {
        $request = $this->getRequest();
        $response = $this->oauthServer->verifyResourceRequest($request);

        if (!$response->isOk()) {
            return $response;
        }

        $accessToken = $this->oauthServer->getAccessToken($request);

        return new JsonModel([
            'id' => $accessToken['user_id'],
            'scope' => $accessToken['scope'],
        ]);
    }
}
