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
use ZourceUser\TaskService\Directory as DirectoryTaskService;

class AdminDirectoryLdap extends AbstractActionController
{
    private $directoryTaskService;
    private $ldapForm;

    public function __construct(DirectoryTaskService $directoryTaskService, FormInterface $ldapForm)
    {
        $this->directoryTaskService = $directoryTaskService;
        $this->ldapForm = $ldapForm;
    }

    public function enableAction()
    {
    }

    public function updateAction()
    {
        $ldapDirectory = $this->directoryTaskService->getDirectory('ldap');

        $this->ldapForm->setData($ldapDirectory['service_options']);

        if ($this->getRequest()->isPost()) {
            $this->ldapForm->setData($this->getRequest()->getPost());

            if ($this->ldapForm->isValid()) {
                $data = $this->ldapForm->getData();

                $this->directoryTaskService->updateDirectoryServiceOptions('ldap', $data);

                $this->flashMessenger()->addSuccessMessage('The LDAP directory has been successfully updated.');

                return $this->redirect()->toRoute('admin/usermanagement/directories');
            }
        }

        return new ViewModel([
            'ldapForm' => $this->ldapForm,
        ]);
    }
}
