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
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZourceContact\TaskService\Contact;
use ZourceUser\Form\Profile as ProfileForm;

class Profile extends AbstractActionController
{
    private $authenticationService;
    private $contactTaskService;
    private $profileForm;

    public function __construct(
        AuthenticationService $authenticationService,
        Contact $contactTaskService,
        ProfileForm $profileForm
    ) {
        $this->authenticationService = $authenticationService;
        $this->contactTaskService = $contactTaskService;
        $this->profileForm = $profileForm;
    }

    public function indexAction()
    {
        $contact = $this->zourceAccount()->getContact();
        $this->profileForm->bind($contact);

        if ($this->getRequest()->isPost()) {
            $this->profileForm->setData(array_merge_recursive(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            ));

            if ($this->profileForm->isValid()) {
                $this->contactTaskService->persistContact($this->profileForm->getData());

                return $this->redirect()->toRoute('settings/profile');
            }
        }

        return new ViewModel([
            'profileForm' => $this->profileForm,
        ]);
    }
}
