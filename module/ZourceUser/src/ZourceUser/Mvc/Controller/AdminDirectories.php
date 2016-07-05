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
use ZourceUser\TaskService\Directory as DirectoryTaskService;

class AdminDirectories extends AbstractActionController
{
    private $directoryTaskService;

    public function __construct(DirectoryTaskService $directoryTaskService)
    {
        $this->directoryTaskService = $directoryTaskService;
    }

    public function indexAction()
    {
        return new ViewModel([
            'directories' => $this->directoryTaskService->getDirectories(),
        ]);
    }

    public function disableAction()
    {
        $this->directoryTaskService->disable($this->params('type'));

        $this->flashMessenger()->addSuccessMessage('The directory has been disabled.');

        return $this->redirect()->toRoute('admin/usermanagement/directories');
    }

    public function enableAction()
    {
        $this->directoryTaskService->enable($this->params('type'));

        $this->flashMessenger()->addSuccessMessage('The directory has been enabled.');

        return $this->redirect()->toRoute('admin/usermanagement/directories');
    }

    public function moveDownAction()
    {
        $this->directoryTaskService->moveDown($this->params('type'));

        $this->flashMessenger()->addSuccessMessage('The directory has been moved down.');

        return $this->redirect()->toRoute('admin/usermanagement/directories');
    }

    public function moveUpAction()
    {
        $this->directoryTaskService->moveUp($this->params('type'));

        $this->flashMessenger()->addSuccessMessage('The directory has been moved up.');

        return $this->redirect()->toRoute('admin/usermanagement/directories');
    }
}
