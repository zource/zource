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
use Zend\View\Model\ViewModel;
use ZourceApplication\TaskService\SettingsManager;

class AdminSettings extends AbstractActionController
{
    /**
     * @var SettingsManager
     */
    private $settingsManager;

    /**
     * @var FormInterface
     */
    private $settingsForm;

    public function __construct(SettingsManager $settingsManager, FormInterface $settingsForm)
    {
        $this->settingsManager = $settingsManager;
        $this->settingsForm = $settingsForm;
    }

    public function indexAction()
    {
        $this->settingsForm->setData($this->settingsManager->getAll());

        if ($this->getRequest()->isPost()) {
            $this->settingsForm->setData($this->getRequest()->getPost());

            if ($this->settingsForm->isValid()) {
                $data = $this->settingsForm->getData();

                $this->settingsManager->set('application_title', $data['application_title']);
                $this->settingsManager->flush();

                $this->flashMessenger()->addSuccessMessage('The settings have been saved.');

                return $this->redirect()->toRoute('admin/system/settings');
            }
        }

        return new ViewModel([
            'settingsForm' => $this->settingsForm,
        ]);
    }
}
