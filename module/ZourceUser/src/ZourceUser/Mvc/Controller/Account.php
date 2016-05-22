<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Mvc\Controller;

use Zend\Form\Form;
use Zend\Form\FormInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZourceUser\Authentication\AuthenticationService;
use ZourceUser\TaskService\PasswordChanger;

class Account extends AbstractActionController
{
    private $authenticationService;
    private $accountForm;
    private $changeIdentityForm;
    private $passwordChanger;

    public function __construct(
        AuthenticationService $authenticationService,
        FormInterface $accountForm,
        FormInterface $changeIdentityForm,
        PasswordChanger $passwordChanger
    ) {
        $this->authenticationService = $authenticationService;
        $this->accountForm = $accountForm;
        $this->changeIdentityForm = $changeIdentityForm;
        $this->passwordChanger = $passwordChanger;
    }

    public function changeCredentialAction()
    {
        if ($this->getRequest()->isPost()) {
            $this->accountForm->setData(array_merge_recursive(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            ));

            if ($this->accountForm->isValid()) {
                $data = $this->accountForm->getData();

                $account = $this->authenticationService->getAccountEntity();

                $this->passwordChanger->changePassword($account, $data['newPassword']);

                return $this->redirect()->toRoute('settings/profile');
            }
        }

        $viewModel = new ViewModel([
            'accountForm' => $this->accountForm,
            'changeIdentityForm' => $this->changeIdentityForm,
        ]);

        $viewModel->setTemplate('zource-user/account/index');

        return $viewModel;
    }

    public function changeIdentityAction()
    {
        if ($this->getRequest()->isPost()) {
            $this->changeIdentityForm->setData(array_merge_recursive(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            ));

            if ($this->changeIdentityForm->isValid()) {
                $data = $this->changeIdentityForm->getData();

                $account = $this->authenticationService->getAccountEntity();

                $this->passwordChanger->changeIdentity($account, 'username', $data['identity']);

                $this->authenticationService->clearIdentity();

                return $this->redirect()->toRoute('settings/profile');
            }
        }

        $viewModel = new ViewModel([
            'accountForm' => $this->accountForm,
            'changeIdentityForm' => $this->changeIdentityForm,
        ]);

        $viewModel->setTemplate('zource-user/account/index');

        return $viewModel;
    }

    public function indexAction()
    {
        return new ViewModel([
            'accountForm' => $this->accountForm,
            'changeIdentityForm' => $this->changeIdentityForm,
        ]);
    }
}
