<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Mvc\Controller;

use Doctrine\ORM\EntityManager;
use Zend\Form\FormInterface;
use Zend\Math\Rand;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZourceUser\TaskService\PasswordChanger;
use ZourceUser\V1\Rest\Account\AccountEntity;
use ZourceUser\V1\Rest\Email\EmailEntity;

class Request extends AbstractActionController
{
    /**
     * @var PasswordChanger
     */
    private $passwordChanger;

    /**
     * @var FormInterface
     */
    private $requestPasswordForm;

    /**
     * @var FormInterface
     */
    private $resetPasswordForm;

    public function __construct(
        PasswordChanger $passwordChanger,
        FormInterface $requestPasswordForm,
        FormInterface $resetPasswordForm
    ) {
        $this->passwordChanger = $passwordChanger;
        $this->requestPasswordForm = $requestPasswordForm;
        $this->resetPasswordForm = $resetPasswordForm;
    }

    public function passwordAction()
    {
        if ($this->getRequest()->isPost()) {
            $this->requestPasswordForm->setData($this->getRequest()->getPost());

            if ($this->requestPasswordForm->isValid()) {
                $data = $this->requestPasswordForm->getData();

                $this->passwordChanger->assignResetCredentialCode($data['email']);

                return $this->redirect()->toRoute('login');
            }
        }

        return new ViewModel([
            'requestPasswordForm' => $this->requestPasswordForm,
        ]);
    }

    public function resetPasswordAction()
    {
        $code = $this->params('code');

        if ($code) {
            $this->resetPasswordForm->get('code')->setValue($code);
        }

        if ($this->getRequest()->isPost()) {
            $this->resetPasswordForm->setData($this->getRequest()->getPost());

            if ($this->resetPasswordForm->isValid()) {
                $data = $this->resetPasswordForm->getData();

                $this->passwordChanger->resetAccountPassword($data['code'], $data['credential']);

                return $this->redirect()->toRoute('login');
            }
        }

        return new ViewModel([
            'resetPasswordForm' => $this->resetPasswordForm,
            'code' => $code,
        ]);
    }
}
