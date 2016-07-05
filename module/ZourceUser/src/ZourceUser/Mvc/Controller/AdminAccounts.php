<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Mvc\Controller;

use Ramsey\Uuid\UuidInterface;
use Zend\Form\FormInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;
use ZourceUser\Entity\Email;
use ZourceUser\TaskService\Account;

class AdminAccounts extends AbstractActionController
{
    /**
     * @var FormInterface
     */
    private $inviteForm;

    /**
     * @var FormInterface
     */
    private $accountForm;

    /**
     * @var Account
     */
    private $accountTaskService;

    public function __construct(FormInterface $inviteForm, FormInterface $accountForm, Account $accountTaskService)
    {
        $this->inviteForm = $inviteForm;
        $this->accountForm = $accountForm;
        $this->accountTaskService = $accountTaskService;
    }

    public function indexAction()
    {
        /** @var Paginator $paginator */
        $paginator = $this->accountTaskService->getPaginator();
        $paginator->setItemCountPerPage(25);
        $paginator->setCurrentPageNumber($this->params()->fromQuery('page', 1));

        return new ViewModel([
            'accounts' => $paginator,
        ]);
    }

    public function inviteAction()
    {
        if ($this->getRequest()->isPost()) {
            $this->inviteForm->setData($this->getRequest()->getPost());

            if ($this->inviteForm->isValid()) {
                $data = $this->inviteForm->getData();

                /** @var \ZourceUser\Entity\Account $account */
                $account = $this->accountTaskService->inviteAccount($data);
                $emailAddresses = $account->getEmailAddresses();

                $this->flashMessenger()->addSuccessMessage(sprintf(
                    'An invitation has been sent to %s',
                    $emailAddresses->get(0)->getAddress()
                ));

                return $this->redirect()->toRoute('admin/usermanagement/accounts');
            }
        }

        return new ViewModel([
            'inviteForm' => $this->inviteForm,
        ]);
    }

    public function updateAction()
    {
        /** @var \ZourceUser\Entity\Account $account */
        $account = $this->accountTaskService->find($this->params('id'));

        if (!$account) {
            return $this->notFoundAction();
        }

        $this->accountForm->bind($account);

        if ($this->getRequest()->isPost()) {
            $this->accountForm->setData($this->getRequest()->getPost());

            if ($this->accountForm->isValid()) {
                $account = $this->accountForm->getData();

                $this->accountTaskService->persist($account);

                return $this->redirect()->toRoute('admin/usermanagement/accounts');
            }
        }

        return new ViewModel([
            'account' => $account,
            'accountForm' => $this->accountForm,
        ]);
    }

    public function deleteAction()
    {
        /** @var \ZourceUser\Entity\Account $account */
        $account = $this->accountTaskService->find($this->params('id'));

        if (!$account) {
            return $this->notFoundAction();
        }

        /** @var Email $emailAddress */
        $emailAddress = $account->getEmailAddresses()->get(0);

        /** @var UuidInterface $id */
        $id = $account->getId();

        $this->accountTaskService->remove($account);

        if ($emailAddress) {
            $this->flashMessenger()->addSuccessMessage(sprintf(
                'The account with e-mail address %s has been deleted.',
                $emailAddress->getAddress()
            ));
        } else {
            $this->flashMessenger()->addSuccessMessage(sprintf(
                'The account with id %s has been deleted.',
                $id->toString()
            ));
        }

        return $this->redirect()->toRoute('admin/usermanagement/accounts');
    }
}
