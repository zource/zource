<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\Mvc\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZourceDaemon\TaskService\Daemon;

class AdminDaemon extends AbstractActionController
{
    /**
     * @var Daemon
     */
    private $daemonTaskService;

    public function __construct(Daemon $daemonTaskService)
    {
        $this->daemonTaskService = $daemonTaskService;
    }

    public function indexAction()
    {
        $stats = $this->daemonTaskService->getStats();
        $tubes = $this->daemonTaskService->getTubeStats();

        return new ViewModel([
            'stats' => $stats,
            'tubes' => $tubes,
        ]);
    }
}
