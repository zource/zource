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
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;

class AdminGroups extends AbstractActionController
{
    /**
     * @var FormInterface
     */
    private $groupForm;

    /**
     * @var Roles
     */
    private $groupTaskService;

    public function __construct(FormInterface $groupForm, Roles $groupTaskService)
    {
        $this->groupForm = $groupForm;
        $this->groupTaskService = $groupTaskService;
    }

    public function indexAction()
    {
        /** @var Paginator $paginator */
        $paginator = $this->groupTaskService->getPaginator();
        $paginator->setItemCountPerPage(25);
        $paginator->setCurrentPageNumber($this->params()->fromQuery('page', 1));

        return new ViewModel([
            'groups' => $paginator,
        ]);
    }

    public function createAction()
    {
        if ($this->getRequest()->isPost()) {
            $this->groupForm->setData($this->getRequest()->getPost());

            if ($this->groupForm->isValid()) {
                $data = $this->groupForm->getData();

                $this->roleTaskService->persistFromArray($data);

                return $this->redirect()->toRoute('admin/usermanagement/roles');
            }
        }

        return new ViewModel([
            'groupForm' => $this->groupForm,
        ]);
    }

    public function updateAction()
    {
        $group = $this->roleTaskService->find($this->params('id'));

        if (!$group) {
            return $this->notFoundAction();
        }

        $this->groupForm->bind($group);

        if ($this->getRequest()->isPost()) {
            $this->groupForm->setData($this->getRequest()->getPost());

            if ($this->groupForm->isValid()) {
                $group = $this->groupForm->getData();

                $this->roleTaskService->persist($group);

                return $this->redirect()->toRoute('admin/usermanagement/roles');
            }
        }

        return new ViewModel([
            'group' => $group,
            'groupForm' => $this->groupForm,
        ]);
    }

    public function deleteAction()
    {
        $role = $this->roleTaskService->find($this->params('id'));

        if (!$role) {
            return $this->notFoundAction();
        }

        $this->roleTaskService->remove($role);

        return $this->redirect()->toRoute('admin/usermanagement/roles');
    }
}
