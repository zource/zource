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
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;
use ZourceContact\TaskService\Contact as ContactTaskService;
use ZourceContact\ValueObject\ContactEntry;

class Company extends AbstractActionController
{
    /**
     * @var ContactTaskService
     */
    private $contactService;

    /**
     * @var FormInterface
     */
    private $contactForm;

    public function __construct(ContactTaskService $contactService, FormInterface $contactForm)
    {
        $this->contactService = $contactService;
        $this->contactForm = $contactForm;
    }

    public function createAction()
    {
        $this->contactForm->get('avatar')->setValue('building');

        if ($this->getRequest()->isPost()) {
            $this->contactForm->setData($this->getRequest()->getPost());

            if ($this->contactForm->isValid()) {
                $person = $this->contactService->createCompany($this->contactForm->getData());

                return $this->redirect()->toRoute('contacts/view', [
                    'type' => ContactEntry::TYPE_COMPANY,
                    'id' => $person->getId()->toString(),
                ]);
            }
        }

        return new ViewModel([
            'contactForm' => $this->contactForm,
        ]);
    }

    public function updateAction()
    {
        $company = $this->contactService->findCompany($this->params('id'));
        if (!$company) {
            return $this->notFoundAction();
        }

        $this->contactForm->bind($company);

        if ($this->getRequest()->isPost()) {
            $this->contactForm->setData($this->getRequest()->getPost());

            if ($this->contactForm->isValid()) {
                $company = $this->contactService->persistContact($this->contactForm->getData());

                return $this->redirect()->toRoute('contacts/view', [
                    'type' => ContactEntry::TYPE_COMPANY,
                    'id' => $company->getId()->toString(),
                ]);
            }
        }

        return new ViewModel([
            'company' => $company,
            'contactForm' => $this->contactForm,
        ]);
    }

    public function deleteAction()
    {
        $company = $this->contactService->findCompany($this->params('id'));
        if (!$company) {
            return $this->notFoundAction();
        }

        $this->contactService->deleteContact($company);

        return $this->redirect()->toRoute('contacts');
    }
}
