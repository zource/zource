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
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;
use ZourceContact\TaskService\Contact as ContactTaskService;

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
        /** @var Paginator $contactsPaginator */
        $contactsPaginator = $this->contactService->getOverviewPaginator();
        $contactsPaginator->setCurrentPageNumber($this->params()->fromQuery('page', 1));
        $contactsPaginator->setItemCountPerPage(50);

        return new ViewModel([
            'contactsPaginator' => $contactsPaginator,
        ]);
    }

    public function filterAction()
    {
        $filterName = $this->params('name');

        /** @var Paginator $contactsPaginator */
        $contactsPaginator = $this->contactService->getFilterPaginator($filterName);
        $contactsPaginator->setCurrentPageNumber($this->params()->fromQuery('page', 1));
        $contactsPaginator->setItemCountPerPage(50);

        return new ViewModel([
            'contactsPaginator' => $contactsPaginator,
        ]);
    }

    public function viewAction()
    {
        $contact = $this->contactService->findContact($this->params('type'), $this->params('id'));

        if (!$contact) {
            return $this->notFoundAction();
        }

        $viewModel = new ViewModel();

        switch ($this->params('type')) {
            case 'company':
                $viewModel->setVariable('company', $contact);
                $viewModel->setTemplate('zource-contact/directory/view-company');
                break;

            case 'person':
                $viewModel->setVariable('person', $contact);
                $viewModel->setTemplate('zource-contact/directory/view-person');
                break;

            default:
                throw new RuntimeException('Invalid type provided.');
        }

        return $viewModel;
    }
}
