<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\Mvc\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Zend\Form\FormInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZourceApplication\Entity\Plugin;
use ZourceApplication\TaskService\PluginManager;

class AdminPlugins extends AbstractActionController
{
    /**
     * @var FormInterface
     */
    private $installForm;

    /**
     * @var PluginManager
     */
    private $pluginManager;

    /**
     * Initializes a new instance of this class.
     *
     * @param FormInterface $installForm
     * @param PluginManager $pluginManager
     */
    public function __construct($installForm, PluginManager $pluginManager)
    {
        $this->installForm = $installForm;
        $this->pluginManager = $pluginManager;
    }

    public function indexAction()
    {
        if ($this->getRequest()->isPost()) {
            $this->installForm->setData($this->getRequest()->getPost());

            if ($this->installForm->isValid()) {
                $data = $this->installForm->getData();

                $this->pluginManager->install($data['name']);

                return $this->redirect()->toRoute('admin/system/plugins');
            }
        }

        return new ViewModel([
            'plugins' => $this->pluginManager->getPlugins(),
            'installForm' => $this->installForm,
        ]);
    }

    public function updateAction()
    {
        $plugin = $this->pluginManager->getPlugin($this->params('id'));

        if (!$plugin) {
            return $this->notFoundAction();
        }

        $this->pluginManager->update($plugin);

        return $this->redirect()->toRoute('admin/system/plugins');
    }

    public function uninstallAction()
    {
        $plugin = $this->pluginManager->getPlugin($this->params('id'));

        if (!$plugin) {
            return $this->notFoundAction();
        }

        $this->pluginManager->uninstall($plugin);

        return $this->redirect()->toRoute('admin/system/plugins');
    }
}
