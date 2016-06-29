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

class AdminSettings extends AbstractActionController
{
    /**
     * @var FormInterface
     */
    private $settingsForm;

    public function __construct(FormInterface $settingsForm)
    {
        $this->settingsForm = $settingsForm;
    }

    public function indexAction()
    {
        if ($this->getRequest()->isPost()) {
            $this->settingsForm->setData($this->getRequest()->getPost());

            if ($this->settingsForm->isValid()) {
                $data = $this->settingsForm->getData();

                var_dump($data);
                exit;
            }
        }

        return new ViewModel([
            'settingsForm' => $this->settingsForm,
        ]);
    }
}
