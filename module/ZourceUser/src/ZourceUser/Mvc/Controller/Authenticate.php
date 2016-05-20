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
use Zend\Authentication\Storage\NonPersistent;
use Zend\Form\FormInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;
use ZourceUser\Entity\AccountInterface;

class Authenticate extends AbstractActionController
{
    /**
     * @var AuthenticationService
     */
    private $authenticationService;

    /**
     * @var FormInterface
     */
    private $authenticateForm;

    /**
     * @var FormInterface
     */
    private $verifyCodeForm;

    /**
     * @var Container
     */
    private $authSession;

    public function __construct(
        AuthenticationService $authenticationService,
        FormInterface $authenticateForm,
        FormInterface $verifyCodeForm,
        Container $authSession
    ) {
        $this->authenticationService = $authenticationService;
        $this->authenticateForm = $authenticateForm;
        $this->verifyCodeForm = $verifyCodeForm;
        $this->authSession = $authSession;
    }

    public function loginAction()
    {
        if ($this->authenticationService->hasIdentity()) {
            return $this->redirect()->toRoute('dashboard');
        }

        $storage = $this->authenticationService->getStorage();
        $this->authenticationService->setStorage(new NonPersistent());

        $redir = $this->params()->fromQuery('redir', $this->params()->fromPost('redir'));
        if ($redir !== null) {
            $this->authSession->url = $redir;

            return $this->redirect()->toRoute('login');
        }

        if ($this->getRequest()->isPost()) {
            $this->authenticateForm->setData($this->getRequest()->getPost());

            if ($this->authenticateForm->isValid()) {
                /** @var AccountInterface $account */
                $account = $this->zourceAccount();

                $this->authSession->identity = $this->identity();
                $this->authSession->verified = false;

                $this->authenticationService->setStorage($storage);
                
                return $this->redirectAfterLogin($account);
            }
        }

        $this->resetTwoFactorAuthentication();

        return new ViewModel([
            'authenticateForm' => $this->authenticateForm,
        ]);
    }

    public function loginTfaAction()
    {
        if (!$this->authSession->identity) {
            return $this->redirect()->toRoute('login');
        }

        if ($this->getRequest()->isPost()) {
            $this->verifyCodeForm->setData($this->getRequest()->getPost());

            /** @var AccountInterface $account */
            $account = $this->zourceIdentity($this->authSession->identity)->getAccount();

            /** @var \ZourceUser\InputFilter\VerifyCode $inputFilter */
            $inputFilter = $this->verifyCodeForm->getInputFilter();
            $inputFilter->setOneTimePasswordType($account->getTwoFactorAuthenticationType());
            $inputFilter->setOneTimePasswordCode($account->getTwoFactorAuthenticationCode());

            if ($this->verifyCodeForm->isValid()) {
                $this->authSession->verified = true;

                return $this->redirectAfterLogin($account);
            }
        }

        return new ViewModel([
            'verifyCodeForm' => $this->verifyCodeForm,
        ]);
    }

    public function logoutAction()
    {
        // Clear the identity and we also regenerate a new session id in order to make sure that new logins always
        // have a unique session id.
        
        $this->authenticationService->clearIdentity();

        $this->authSession->getManager()->expireSessionCookie();

        $this->resetTwoFactorAuthentication();

        return $this->redirect()->toRoute('login');
    }

    private function redirectAfterLogin(AccountInterface $account)
    {
        if (!$this->authSession->verified && $account->hasTwoFactorAuthentication()) {
            return $this->redirect()->toRoute('login-tfa');
        }

        $this->authenticationService->getStorage()->write($this->authSession->identity);

        $this->resetTwoFactorAuthentication();

        if ($this->authSession->url) {
            $url = $this->authSession->url;

            unset($this->authSession->url);

            return $this->redirect()->toUrl($url);
        }

        return $this->redirect()->toRoute('dashboard');
    }

    private function resetTwoFactorAuthentication()
    {
        $this->authSession->identity = null;
        $this->authSession->verified = false;
    }
}
