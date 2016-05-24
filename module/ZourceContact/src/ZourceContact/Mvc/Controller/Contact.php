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
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;
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
        $contact = $this->contactService->findContact($this->params('type'), $this->params('id'));

        if (!$contact) {
            return $this->notFoundAction();
        }

        $viewModel = new ViewModel();

        switch ($this->params('type')) {
            case ContactEntry::TYPE_COMPANY:
                $viewModel->setVariable('company', $contact);
                $viewModel->setTemplate('zource-contact/company/view');
                break;

            case ContactEntry::TYPE_PERSON:
                $viewModel->setVariable('person', $contact);
                $viewModel->setTemplate('zource-contact/person/view');
                break;

            default:
                throw new RuntimeException('Invalid type provided.');
        }

        return $viewModel;
    }

    public function activityStreamAction()
    {
        return $this->notFoundAction();
    }

    public function vCardAction()
    {
        $contact = $this->contactService->findContact($this->params('type'), $this->params('id'));
        if (!$contact) {
            return $this->notFoundAction();
        }

        $builder = new VCardBuilder();

        switch ($this->params('type')) {
            case ContactEntry::TYPE_COMPANY:
                $vCard = $builder->buildCompany($contact);
                break;

            case ContactEntry::TYPE_PERSON:
                $vCard = $builder->buildPerson($contact);
                break;

            default:
                throw new RuntimeException('Invalid type provided.');
        }

        $data = $vCard->serialize();

        $response = new Response();
        $response->setStatusCode(Response::STATUS_CODE_200);
        $response->setContent($data);

        $headers = $response->getHeaders();
        //$headers->addHeaderLine('Content-Disposition', 'attachment; filename="' . $contact->getFullName() . '.vcf"');
        $headers->addHeaderLine('Content-Length', strlen($data));
        $headers->addHeaderLine('Content-Type', 'text/plain');

        return $response;
    }
}
