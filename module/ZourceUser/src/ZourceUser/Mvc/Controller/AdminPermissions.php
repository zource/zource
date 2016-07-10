<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Mvc\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZourceUser\TaskService\Permissions;

class AdminPermissions extends AbstractActionController
{
    /**
     * @var Permissions
     */
    private $permissionsTaskService;

    public function __construct(Permissions $permissionsTaskService)
    {
        $this->permissionsTaskService = $permissionsTaskService;
    }

    public function indexAction()
    {
        return new ViewModel([
            'permissions' => $this->permissionsTaskService->getPermissions(),
        ]);
    }
}
