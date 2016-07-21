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
use ZourceApplication\TaskService\CronManager;

class AdminCron extends AbstractActionController
{
    /**
     * @var CronManager
     */
    private $cronManager;

    /**
     * @var FormInterface
     */
    private $cronjobForm;

    public function __construct(CronManager $cronManager, FormInterface $cronjobForm)
    {
        $this->cronManager = $cronManager;
        $this->cronjobForm = $cronjobForm;
    }

    public function indexAction()
    {
        $cronjobs = $this->cronManager->getCronjobs();

        return new ViewModel([
            'cronjobs' => $cronjobs,
        ]);
    }

    public function createAction()
    {
        if ($this->getRequest()->isPost()) {
            $this->cronjobForm->setData($this->getRequest()->getPost());

            if ($this->cronjobForm->isValid()) {
                $data = $this->cronjobForm->getData();

                $this->cronManager->persistFromArray($data);

                return $this->redirect()->toRoute('admin/system/cron');
            }
        }

        return new ViewModel([
            'cronjobForm' => $this->cronjobForm,
        ]);
    }

    public function updateAction()
    {
        $cronjob = $this->cronManager->find($this->params('id'));
        if (!$cronjob) {
            return $this->notFoundAction();
        }

        $this->cronjobForm->bind($cronjob);

        if ($this->getRequest()->isPost()) {
            $this->cronjobForm->setData($this->getRequest()->getPost());

            if ($this->cronjobForm->isValid()) {
                $data = $this->cronjobForm->getData();

                $this->cronManager->persist($data);

                return $this->redirect()->toRoute('admin/system/cron');
            }
        }

        return new ViewModel([
            'cronjob' => $cronjob,
            'cronjobForm' => $this->cronjobForm,
        ]);
    }

    public function deleteAction()
    {
        $cronjob = $this->cronManager->find($this->params('id'));
        if (!$cronjob) {
            return $this->notFoundAction();
        }

        $this->cronManager->remove($cronjob);

        return $this->redirect()->toRoute('admin/system/cron');
    }
}
