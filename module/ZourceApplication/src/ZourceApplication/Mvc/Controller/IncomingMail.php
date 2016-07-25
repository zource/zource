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
use Zend\Mvc\Controller\AbstractConsoleController;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;
use ZourceApplication\Entity\Dashboard as DashboardEntity;
use ZourceApplication\TaskService\Dashboard as DashboardTaskService;
use ZourceApplication\TaskService\Gadget as GadgetTaskService;
use ZourceApplication\Worker\CheckIncomingMail;
use ZourceDaemon\TaskService\Daemon;
use ZourceDaemon\ValueObject\Job;

class IncomingMail extends AbstractConsoleController
{
    /**
     * @var Daemon
     */
    private $daemonTaskService;

    public function __construct(Daemon $daemonTaskService)
    {
        $this->daemonTaskService = $daemonTaskService;
    }

    public function checkAction()
    {
        $this->getConsole()->writeLine('Enqueuing a new job to check incoming email messages.');

        $job = new Job(CheckIncomingMail::class);

        $this->daemonTaskService->enqueue($job);
    }
}
