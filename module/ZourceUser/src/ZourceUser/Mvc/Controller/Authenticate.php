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
use Zend\Form\FormInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class Authenticate extends AbstractActionController
{
    /**
     * @var AuthenticationService
     */
    private $authenticationService;

    /**
     * @var Form
     */
    private $authenticateForm;

    /**
     * @var Container
     */
    private $redirSession;

    /**
     * Initializes a new instance of this class.
     *
     * @param AuthenticationService $authenticationService
     * @param FormInterface $authenticateForm
     */
    public function __construct(AuthenticationService $authenticationService, FormInterface $authenticateForm)
    {
        $this->authenticationService = $authenticationService;
        $this->authenticateForm = $authenticateForm;
        $this->redirSession = new Container('authRedir');
    }

    public function loginAction()
    {
        if ($this->authenticationService->hasIdentity()) {
            return $this->redirect()->toRoute('dashboard');
        }

        $redir = $this->params()->fromQuery('redir', $this->params()->fromPost('redir'));
        if ($redir !== null) {
            $this->redirSession->url = $redir;

            return $this->redirect()->toRoute('login');
        }

        if ($this->getRequest()->isPost()) {
            $this->authenticateForm->setData($this->getRequest()->getPost());

            if ($this->authenticateForm->isValid()) {
                return $this->redirectAfterLogin();
            }
        }

        return new ViewModel([
            'authenticateForm' => $this->authenticateForm,
        ]);
    }

    public function logoutAction()
    {
        $this->authenticationService->clearIdentity();
        
        return $this->redirect()->toRoute('login');
    }

    private function redirectAfterLogin()
    {
        if ($this->redirSession->url) {
            $url = $this->redirSession->url;

            unset($this->redirSession->url);

            return $this->redirect()->toUrl($url);
        }

        return $this->redirect()->toRoute('dashboard');
    }
}
