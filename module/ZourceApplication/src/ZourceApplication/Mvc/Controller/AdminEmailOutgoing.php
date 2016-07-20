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
use ZourceApplication\Form\OutgoingEmailServer;
use ZourceApplication\TaskService\EmailServers;

class AdminEmailOutgoing extends AbstractActionController
{
    /**
     * @var EmailServers
     */
    private $emailServers;

    /**
     * @var OutgoingEmailServer
     */
    private $serverForm;

    public function __construct(EmailServers $emailServers, OutgoingEmailServer $serverForm)
    {
        $this->emailServers = $emailServers;
        $this->serverForm = $serverForm;
    }

    public function indexAction()
    {
        return new ViewModel([
            'servers' => $this->emailServers->getOutgoingServers(),
        ]);
    }

    public function createAction()
    {
        if ($this->getRequest()->isPost()) {
            $this->serverForm->setData($this->getRequest()->getPost());

            if ($this->serverForm->isValid()) {
                $data = $this->serverForm->getData();

                $this->emailServers->persistOutgoingFromArray($data);

                return $this->redirect()->toRoute('admin/system/email/outgoing');
            }
        }

        return new ViewModel([
            'serverForm' => $this->serverForm,
        ]);
    }

    public function updateAction()
    {
        $id = $this->params('id');
        $server = $this->emailServers->findOutgoing($id);
        if (!$server) {
            return $this->notFoundAction();
        }

        $this->serverForm->setData($server);

        if ($this->getRequest()->isPost()) {
            $this->serverForm->setData($this->getRequest()->getPost());

            if ($this->serverForm->isValid()) {
                $data = $this->serverForm->getData();

                $this->emailServers->persistOutgoingFromArray($data, $id);

                return $this->redirect()->toRoute('admin/system/email/outgoing');
            }
        }

        return new ViewModel([
            'serverForm' => $this->serverForm,
            'serverId' => $id,
            'server' => $server,
        ]);
    }

    public function deleteAction()
    {
        $id = $this->params('id');

        $this->emailServers->removeOutgoingKey($id);

        return $this->redirect()->toRoute('admin/system/email/outgoing');
    }
}
