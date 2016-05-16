<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Mvc\Controller;

use Zend\Form\FormInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;
use ZourceUser\TaskService\Application as ApplicationService;

class DeveloperApplication extends AbstractActionController
{
    /**
     * @var ApplicationService
     */
    private $applicationService;

    /**
     * @var FormInterface
     */
    private $applicationForm;

    /**
     * @var Container
     */
    private $sessionContainer;

    public function __construct(ApplicationService $applicationService, FormInterface $applicationForm)
    {
        $this->applicationService = $applicationService;
        $this->applicationForm = $applicationForm;
        $this->sessionContainer = new Container('oauthCreationSession');
    }

    public function createAction()
    {
        if ($this->getRequest()->isPost()) {
            $this->applicationForm->setData($this->getRequest()->getPost());

            if ($this->applicationForm->isValid()) {
                $data = $this->applicationForm->getData();

                $clientSecret = $this->applicationService->createApplicationFromArray($this->zourceAccount(), $data);
                $this->sessionContainer->clientSecret = $clientSecret;

                return $this->redirect()->toRoute('settings/applications');
            }
        }

        return new ViewModel([
            'applications' => $this->applicationService->getForAccount($this->zourceAccount()),
            'applicationForm' => $this->applicationForm,
        ]);
    }

    public function updateAction()
    {
        $application = $this->applicationService->getApplication($this->params('id'));
        if (!$application) {
            return $this->notFoundAction();
        }

        if ($application->getAccount() !== $this->zourceAccount()) {
            return $this->notFoundAction();
        }

        $this->applicationForm->bind($application);

        if ($this->getRequest()->isPost()) {
            $this->applicationForm->setData($this->getRequest()->getPost());

            if ($this->applicationForm->isValid()) {
                $updatedApplication = $this->applicationForm->getData();

                $this->applicationService->persistApplication($updatedApplication);

                return $this->redirect()->toRoute('settings/applications');
            }
        }

        return new ViewModel([
            'application' => $application,
            'applicationForm' => $this->applicationForm,
        ]);
    }

    public function deleteAction()
    {
        $application = $this->applicationService->getApplication($this->params('id'));
        if (!$application) {
            return $this->notFoundAction();
        }

        if ($application->getAccount() !== $this->zourceAccount()) {
            return $this->notFoundAction();
        }

        $this->applicationService->deleteApplication($application);

        return $this->redirect()->toRoute('settings/applications');
    }
}
