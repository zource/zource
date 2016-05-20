<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Mvc\Controller;

use Zend\Form\FormInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZourceUser\TaskService\Email as EmailTaskService;
use ZourceUser\V1\Rest\Email\EmailEntity;

class Email extends AbstractActionController
{
    private $emailService;
    private $emailForm;
    private $verifyForm;

    public function __construct(EmailTaskService $emailService, FormInterface $emailForm, FormInterface $verifyForm)
    {
        $this->emailService = $emailService;
        $this->emailForm = $emailForm;
        $this->verifyForm = $verifyForm;
    }

    public function indexAction()
    {
        return new ViewModel([
            'emailAddresses' => $this->emailService->getForAccount($this->zourceAccount()),
        ]);
    }

    public function addAction()
    {
        if ($this->getRequest()->isPost()) {
            $this->emailForm->setData($this->getRequest()->getPost());

            if ($this->emailForm->isValid()) {
                $this->emailService->createFromArray($this->zourceAccount(), $this->emailForm->getData());

                return $this->redirect()->toRoute('settings/email');
            }
        }

        return new ViewModel([
            'emailForm' => $this->emailForm,
        ]);
    }

    public function deleteAction()
    {
        /** @var EmailEntity $emailAddress */
        $emailAddress = $this->emailService->getAddress($this->zourceAccount(), $this->params('id'));
        if (!$emailAddress) {
            return $this->notFoundAction();
        }

        if ($emailAddress->getIsPrimary()) {
            return $this->notFoundAction();
        }

        $this->emailService->delete($emailAddress);

        return $this->redirect()->toRoute('settings/email');
    }

    public function verifyAction()
    {
        $code = $this->params('code', $this->params()->fromPost('code'));

        if ($this->getRequest()->isPost()) {
            $this->verifyForm->setData($this->getRequest()->getPost());

            if ($this->verifyForm->isValid()) {
                $this->emailService->activate($this->zourceAccount(), $this->params('id'), $code);

                return $this->redirect()->toRoute('settings/email');
            }
        } elseif ($code) {
            $this->emailService->activate($this->zourceAccount(), $this->params('id'), $code);

            return $this->redirect()->toRoute('settings/email');
        }

        return new ViewModel([
            'verifyForm' => $this->verifyForm,
        ]);
    }

    public function primaryAction()
    {
        /** @var EmailEntity $emailAddress */
        $emailAddress = $this->emailService->makePrimary(
            $this->zourceAccount(),
            $this->params('id')
        );

        if (!$emailAddress) {
            return $this->notFoundAction();
        }

        return $this->redirect()->toRoute('settings/email');
    }
}
