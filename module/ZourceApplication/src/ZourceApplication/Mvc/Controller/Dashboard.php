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
use Zend\View\Model\JsonModel;
use ZourceApplication\Entity\Dashboard as DashboardEntity;
use ZourceApplication\Entity\WidgetContainer;
use ZourceApplication\TaskService\Dashboard as DashboardTaskService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class Dashboard extends AbstractActionController
{
    /**
     * @var DashboardTaskService
     */
    private $dashboardTaskService;

    /**
     * @var FormInterface
     */
    private $dashboardForm;

    public function __construct(DashboardTaskService $dashboardTaskService, FormInterface $dashboardForm)
    {
        $this->dashboardTaskService = $dashboardTaskService;
        $this->dashboardForm = $dashboardForm;
    }

    public function indexAction()
    {
        $account = $this->zourceAccount();

        $dashboard = $this->dashboardTaskService->getAccountDashboard($account);

        return new ViewModel([
            'dashboard' => $dashboard,
        ]);
    }

    public function widgetDialogAction()
    {
        return new JsonModel([
            'widgets' => [
                'open-weather' => [
                    'label' => 'My Label',
                ],
            ],
        ]);
    }

    public function manageAction()
    {
        $dashboards = $this->dashboardTaskService->getPaginator();

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

                $this->dashboardTaskService->persistFromArray($this->zourceAccount(), $data);

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

        return $this->redirect()->toRoute('dashboard');
    }
}
