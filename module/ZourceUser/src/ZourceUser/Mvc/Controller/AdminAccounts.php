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
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;
use ZourceUser\TaskService\Account;

class AdminAccounts extends AbstractActionController
{
    /**
     * @var FormInterface
     */
    private $accountForm;

    /**
     * @var Account
     */
    private $accountTaskService;

    public function __construct(FormInterface $accountForm, Account $accountTaskService)
    {
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

    public function createAction()
    {
        if ($this->getRequest()->isPost()) {
            $this->accountForm->setData($this->getRequest()->getPost());

            if ($this->accountForm->isValid()) {
                $data = $this->accountForm->getData();

                $this->accountTaskService->persistFromArray($data);

                return $this->redirect()->toRoute('admin/usermanagement/accounts');
            }
        }

        return new ViewModel([
            'accountForm' => $this->accountForm,
        ]);
    }

    public function updateAction()
    {
        $account = $this->accountTaskService->find($this->params('id'));

        if (!$account) {
            return $this->notFoundAction();
        }

        var_dump($account);
        exit;

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
        $account = $this->accountTaskService->find($this->params('id'));

        if (!$account) {
            return $this->notFoundAction();
        }

        $this->accountTaskService->remove($account);

        return $this->redirect()->toRoute('admin/usermanagement/accounts');
    }
}
