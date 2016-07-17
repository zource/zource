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
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use ZourceApplication\TaskService\Gadget as GadgetTaskService;

class Gadget extends AbstractActionController
{
    /**
     * @var GadgetTaskService
     */
    private $gadgetTaskService;

    public function __construct(GadgetTaskService $gadgetTaskService)
    {
        $this->gadgetTaskService = $gadgetTaskService;
    }

    public function loadAction()
    {
        $gadget = $this->gadgetTaskService->find($this->params()->fromQuery('id'));
        if (!$gadget) {
            return $this->notFoundAction();
        }

        $viewModel = new ViewModel([
            'gadget' => $gadget,
        ]);

        $viewModel->setTerminal(true);

        return $viewModel;
    }

    public function updateAction()
    {
        // TODO

        return new JsonModel([]);
    }

    public function updateContainerAction()
    {
        $gadgetContainer = $this->gadgetTaskService->findContainer($this->params('id'));
        if (!$gadgetContainer) {
            return $this->notFoundAction();
        }

        $result = $this->gadgetTaskService->updateGadgetContainer(
            $gadgetContainer,
            $this->getRequest()->getPost()->toArray()
        );

        return new JsonModel($result);
    }
}
