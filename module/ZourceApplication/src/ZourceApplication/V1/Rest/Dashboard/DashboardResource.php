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
use ZF\ApiProblem\ApiProblemResponse;
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
        $dashboard = $this->dashboardTaskService->persistFromArray((array)$data);

        return new DashboardEntity($dashboard);
    }

    public function delete($id)
    {
        /** @var \ZourceApplication\Entity\Dashboard $dashboard */
        $dashboard = $this->dashboardTaskService->find($id);
        if (!$dashboard) {
            return new ApiProblem(ApiProblemResponse::STATUS_CODE_404, 'Entity not found.');
        }

        $this->dashboardTaskService->remove($dashboard);
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

    public function patch($id, $data)
    {
        /** @var \ZourceApplication\Entity\Dashboard $dashboard */
        $dashboard = $this->dashboardTaskService->find($id);
        if (!$dashboard) {
            return new ApiProblem(ApiProblemResponse::STATUS_CODE_404, 'Entity not found.');
        }

        $this->dashboardTaskService->updateFromArray($dashboard, $data);

        return new DashboardEntity($dashboard);
    }

    public function update($id, $data)
    {
        /** @var \ZourceApplication\Entity\Dashboard $dashboard */
        $dashboard = $this->dashboardTaskService->find($id);
        if (!$dashboard) {
            return new ApiProblem(ApiProblemResponse::STATUS_CODE_404, 'Entity not found.');
        }

        $this->dashboardTaskService->updateFromArray($dashboard, $data);

        return new DashboardEntity($dashboard);
    }
}
