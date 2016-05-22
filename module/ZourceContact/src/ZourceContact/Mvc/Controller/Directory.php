<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceContact\Mvc\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;
use ZourceContact\TaskService\Contact as ContactTaskService;
use ZourceContact\ValueObject\ContactEntry;

class Directory extends AbstractActionController
{
    /**
     * @var ContactTaskService
     */
    private $contactService;

    public function __construct(ContactTaskService $contactService)
    {
        $this->contactService = $contactService;
    }

    public function indexAction()
    {
        switch ($this->params()->fromQuery('filter')) {
            case 'companies':
                $filter = ContactEntry::TYPE_COMPANY;
                break;

            case 'people':
                $filter = ContactEntry::TYPE_PERSON;
                break;

            default:
                $filter = null;
                break;
        }

        /** @var Paginator $contactsPaginator */
        $contactsPaginator = $this->contactService->getOverviewPaginator($filter);
        $contactsPaginator->setCurrentPageNumber($this->params()->fromQuery('page', 1));
        $contactsPaginator->setItemCountPerPage(50);

        return new ViewModel([
            'contactsPaginator' => $contactsPaginator,
        ]);
    }
}
