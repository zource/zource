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
use ZourceApplication\TaskService\CronManager;

class AdminCron extends AbstractActionController
{
    /**
     * @var CronManager
     */
    private $cronManager;

    public function __construct(CronManager $cronManager)
    {
        $this->cronManager = $cronManager;
    }

    public function indexAction()
    {
        $cronjobs = $this->cronManager->getCronjobs();

        return new ViewModel([
            'cronjobs' => $cronjobs,
        ]);
    }
}
