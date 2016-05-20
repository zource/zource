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
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZourceUser\Authentication\AuthenticationService;
use ZourceUser\TaskService\PasswordChanger;

class Account extends AbstractActionController
{
    private $authenticationService;
    private $accountForm;
    private $passwordChanger;

    public function __construct(
        AuthenticationService $authenticationService,
        Form $accountForm,
        PasswordChanger $passwordChanger
    ) {
        $this->authenticationService = $authenticationService;
        $this->accountForm = $accountForm;
        $this->passwordChanger = $passwordChanger;
    }

    public function indexAction()
    {
        if ($this->getRequest()->isPost()) {
            $this->accountForm->setData(array_merge_recursive(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            ));

            if ($this->accountForm->isValid()) {
                $data = $this->accountForm->getData();

                $account = $this->authenticationService->getAccountInterface();

                $this->passwordChanger->changePassword($account, $data['newPassword']);

                return $this->redirect()->toRoute('settings/profile');
            }
        }

        return new ViewModel([
            'form' => $this->accountForm,
        ]);
    }
}
