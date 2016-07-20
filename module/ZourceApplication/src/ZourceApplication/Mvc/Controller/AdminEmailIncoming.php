<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\Mvc\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZourceApplication\Form\IncomingEmailAccount;
use ZourceApplication\TaskService\EmailServers;

class AdminEmailIncoming extends AbstractActionController
{
    /**
     * @var EmailServers
     */
    private $emailServers;

    /**
     * @var IncomingEmailAccount
     */
    private $accountForm;

    public function __construct(EmailServers $emailServers, IncomingEmailAccount $accountForm)
    {
        $this->emailServers = $emailServers;
        $this->accountForm = $accountForm;
    }

    public function indexAction()
    {
        return new ViewModel([
            'accounts' => $this->emailServers->getIncomingAccounts(),
        ]);
    }

    public function createAction()
    {
        if ($this->getRequest()->isPost()) {
            $this->accountForm->setData($this->getRequest()->getPost());

            if ($this->accountForm->isValid()) {
                $data = $this->accountForm->getData();

                $this->emailServers->persistIncomingFromArray($data);

                return $this->redirect()->toRoute('admin/system/email/incoming');
            }
        }

        return new ViewModel([
            'accountForm' => $this->accountForm,
        ]);
    }

    public function updateAction()
    {
        $id = $this->params('id');
        $account = $this->emailServers->findIncoming($id);
        if (!$account) {
            return $this->notFoundAction();
        }

        $this->accountForm->setData($account);

        if ($this->getRequest()->isPost()) {
            $this->accountForm->setData($this->getRequest()->getPost());

            if ($this->accountForm->isValid()) {
                $data = $this->accountForm->getData();

                $this->emailServers->persistIncomingFromArray($data, $id);

                return $this->redirect()->toRoute('admin/system/email/incoming');
            }
        }

        return new ViewModel([
            'accountForm' => $this->accountForm,
            'accountId' => $id,
            'account' => $account,
        ]);
    }

    public function deleteAction()
    {
        $id = $this->params('id');

        $this->emailServers->removeIncomingKey($id);

        return $this->redirect()->toRoute('admin/system/email/incoming');
    }
}
