<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\V1\Rest\Dashboard;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;
use ZourceApplication\TaskService\Dashboard;

class DashboardResource extends AbstractResourceListener
{
    /**
     * @var Dashboard
     */
    private $dashboardTaskService;

    /**
     * Initializes a new instance of this class.
     *
     * @param Dashboard $dashboardTaskService
     */
    public function __construct(Dashboard $dashboardTaskService)
    {
        $this->dashboardTaskService = $dashboardTaskService;
    }

    public function create($data)
    {
        var_dump($this->getIdentity()->getAuthenticationIdentity());
        exit;
        $dashboard = new \ZourceApplication\Entity\Dashboard();
        $dashboard->setName($data->name);

        $this->dashboardTaskService->persist($dashboard);

        return $dashboard;
    }

    public function fetch($id)
    {
        $dashboard = $this->dashboardTaskService->find($id);
        if (!$dashboard) {
            return null;
        }

        return new DashboardEntity($dashboard);
    }

    public function fetchAll($params = array())
    {
        $adapter = $this->dashboardTaskService->getPaginator()->getAdapter();

        return new DashboardCollection($adapter);
    }
}
