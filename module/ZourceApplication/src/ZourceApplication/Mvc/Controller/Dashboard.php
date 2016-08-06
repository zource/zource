<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\Mvc\Controller;

use Zend\Form\FormInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;
use ZourceApplication\Entity\Dashboard as DashboardEntity;
use ZourceApplication\TaskService\Dashboard as DashboardTaskService;
use ZourceApplication\TaskService\Gadget as GadgetTaskService;

class Dashboard extends AbstractActionController
{
    /**
     * @var FormInterface
     */
    private $dashboardForm;

    /**
     * @var DashboardTaskService
     */
    private $dashboardTaskService;

    /**
     * @var GadgetTaskService
     */
    private $gadgetTaskService;

    public function __construct(
        FormInterface $dashboardForm,
        DashboardTaskService $dashboardTaskService,
        GadgetTaskService $gadgetTaskService
    ) {
        $this->dashboardForm = $dashboardForm;
        $this->dashboardTaskService = $dashboardTaskService;
        $this->gadgetTaskService = $gadgetTaskService;
    }

    public function indexAction()
    {
        $account = $this->zourceAccount();

        $dashboard = $this->dashboardTaskService->getAccountDashboard($account);

        return new ViewModel([
            'dashboard' => $dashboard,
            'gadgets' => $this->gadgetTaskService->getAvailableGadgets(),
            'gadgetCategories' => $this->gadgetTaskService->getGadgetCategories(),
        ]);
    }

    public function manageAction()
    {
        /** @var Paginator $dashboards */
        $dashboards = $this->dashboardTaskService->getPaginator();
        $dashboards->setCurrentPageNumber($this->params()->fromQuery('page', 1));
        $dashboards->setItemCountPerPage(25);

        return new ViewModel([
            'dashboards' => $dashboards,
        ]);
    }

    public function selectAction()
    {
        /** @var DashboardEntity $dashboard */
        $dashboard = $this->dashboardTaskService->find($this->params('id'));
        if (!$dashboard) {
            return $this->notFoundAction();
        }

        $this->dashboardTaskService->selectDashboard($this->zourceAccount(), $dashboard);

        return $this->redirect()->toRoute('dashboard');
    }

    public function createAction()
    {
        if ($this->getRequest()->isPost()) {
            $this->dashboardForm->setData($this->getRequest()->getPost());

            if ($this->dashboardForm->isValid()) {
                $data = $this->dashboardForm->getData();

                $this->dashboardTaskService->persistFromArray($data);

                return $this->redirect()->toRoute('dashboard/manage');
            }
        }

        return new ViewModel([
            'dashboardForm' => $this->dashboardForm,
        ]);
    }

    public function updateAction()
    {
        /** @var DashboardEntity $dashboard */
        $dashboard = $this->dashboardTaskService->find($this->params('id'));
        if (!$dashboard) {
            return $this->notFoundAction();
        }

        return new ViewModel([
            'dashboard' => $dashboard,
        ]);
    }

    public function deleteAction()
    {
        /** @var DashboardEntity $dashboard */
        $dashboard = $this->dashboardTaskService->find($this->params('id'));
        if (!$dashboard) {
            return $this->notFoundAction();
        }

        $this->dashboardTaskService->remove($dashboard);

        return $this->redirect()->toRoute('dashboard/manage');
    }
}
