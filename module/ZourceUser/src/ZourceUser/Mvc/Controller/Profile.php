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
use ZourceUser\Form\Profile as ProfileForm;

class Profile extends AbstractActionController
{
    private $authenticationService;
    private $profileForm;

    public function __construct(AuthenticationService $authenticationService, ProfileForm $profileForm)
    {
        $this->authenticationService = $authenticationService;
        $this->profileForm = $profileForm;
    }

    public function indexAction()
    {
        if ($this->getRequest()->isPost()) {
            $this->profileForm->setData(array_merge_recursive(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            ));

            if ($this->profileForm->isValid()) {
                var_dump($this->profileForm->getData());
                exit;

                return $this->redirect()->toRoute('settings/profile');
            }
        }

        return new ViewModel([
            'profileForm' => $this->profileForm,
        ]);
    }
}
