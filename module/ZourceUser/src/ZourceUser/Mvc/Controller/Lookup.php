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
use Zend\View\Model\JsonModel;
use ZourceUser\TaskService\Account;
use ZourceUser\TaskService\Group;

class Lookup extends AbstractActionController
{
    /**
     * @var Account
     */
    private $accountTaskService;

    /**
     * @var Group
     */
    private $groupTaskService;

    public function __construct(Account $accountTaskService, Group $groupTaskService)
    {
        $this->accountTaskService = $accountTaskService;
        $this->groupTaskService = $groupTaskService;
    }

    public function accountAction()
    {
        $result = $this->accountTaskService->lookup($this->params()->fromQuery('q'));

        return new JsonModel($result);
    }

    public function groupAction()
    {
        $result = $this->groupTaskService->lookup($this->params()->fromQuery('q'));

        return new JsonModel($result);
    }
}
