<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Mvc\Controller;

use Zend\Authentication\AuthenticationService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;
use ZourceUser\TaskService\Application as ApplicationService;

class Application extends AbstractActionController
{
    /**
     * @var ApplicationService
     */
    private $applicationService;

    /**
     * @var Container
     */
    private $sessionContainer;

    public function __construct(ApplicationService $applicationService)
    {
        $this->applicationService = $applicationService;
        $this->sessionContainer = new Container('oauthCreationSession');
    }

    public function indexAction()
    {
        $clientSecret = null;

        if ($this->sessionContainer->clientSecret) {
            $clientSecret = $this->sessionContainer->clientSecret;
            $this->sessionContainer->clientSecret = null;
        }

        return new ViewModel([
            'applications' => $this->applicationService->getForAccount($this->zourceAccount()),
            'clientSecret' => $clientSecret,
        ]);
    }
}
