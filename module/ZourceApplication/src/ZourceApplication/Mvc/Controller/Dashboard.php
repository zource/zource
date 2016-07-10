<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\Mvc\Controller;

use ZourceApplication\TaskService\Dashboard as DashboardTaskService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class Dashboard extends AbstractActionController
{
    /**
     * @var DashboardTaskService
     */
    private $dashboardTaskService;

    public function __construct(DashboardTaskService $dashboardTaskService)
    {
        $this->dashboardTaskService = $dashboardTaskService;
    }

    public function indexAction()
    {
        $account = $this->zourceAccount();

        $dashboard = $this->dashboardTaskService->findForAccount($account);

        return new ViewModel([
            'dashboard' => $dashboard,
        ]);
    }
}
