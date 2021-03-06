<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceContact\Mvc\Controller;

use RuntimeException;
use Zend\Form\FormInterface;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;
use ZourceContact\Entity\Company;
use ZourceContact\Entity\Person;
use ZourceContact\TaskService\Contact as ContactTaskService;
use ZourceContact\TaskService\VCardBuilder;
use ZourceContact\ValueObject\ContactEntry;

class Contact extends AbstractActionController
{
    /**
     * @var ContactTaskService
     */
    private $contactService;

    public function __construct(ContactTaskService $contactService)
    {
        $this->contactService = $contactService;
    }

    public function viewAction()
    {
        $contact = $this->contactService->find($this->params('id'));

        if (!$contact) {
            return $this->notFoundAction();
        }

        $viewModel = new ViewModel();

        switch (true) {
            case $contact instanceof Company:
                $viewModel->setVariable('company', $contact);
                $viewModel->setTemplate('zource-contact/company/view');
                break;

            case $contact instanceof Person:
                $viewModel->setVariable('person', $contact);
                $viewModel->setTemplate('zource-contact/person/view');
                break;

            default:
                throw new RuntimeException('Invalid type provided.');
        }

        return $viewModel;
    }
}
