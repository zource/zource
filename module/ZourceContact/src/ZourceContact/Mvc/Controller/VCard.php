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

class VCard extends AbstractActionController
{
    /**
     * @var ContactTaskService
     */
    private $contactService;

    public function __construct(ContactTaskService $contactService)
    {
        $this->contactService = $contactService;
    }

    public function vCardAction()
    {
        $contact = $this->contactService->find($this->params('id'));
        if (!$contact) {
            return $this->notFoundAction();
        }

        $builder = new VCardBuilder();

        switch (true) {
            case $contact instanceof Company:
                $vcard = $builder->buildCompany($contact);
                break;

            case $contact instanceof Person:
                $vcard = $builder->buildPerson($contact);
                break;

            default:
                throw new RuntimeException('Invalid type provided.');
        }

        $data = $vcard->serialize();

        $response = new Response();
        $response->setStatusCode(Response::STATUS_CODE_200);
        $response->setContent($data);

        $headers = $response->getHeaders();
        $headers->addHeaderLine('Content-Disposition', 'attachment; filename="' . $contact->getDisplayName() . '.vcf"');
        $headers->addHeaderLine('Content-Length', strlen($data));
        $headers->addHeaderLine('Content-Type', 'text/plain');

        return $response;
    }
}
