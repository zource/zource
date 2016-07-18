<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceDaemon\Mvc\Controller;

use Zend\Mvc\Controller\AbstractConsoleController;
use ZourceDaemon\TaskService\Daemon as DaemonTaskService;

class Daemon extends AbstractConsoleController
{
    /**
     * @var DaemonTaskService
     */
    private $daemonTaskService;

    public function __construct(DaemonTaskService $daemonTaskService)
    {
        $this->daemonTaskService = $daemonTaskService;
    }

    public function runAction()
    {
        return $this->daemonTaskService->run();
    }
}
