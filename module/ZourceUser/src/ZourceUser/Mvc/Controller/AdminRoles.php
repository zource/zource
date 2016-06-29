<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Mvc\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Zend\Form\FormInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;
use ZourceUser\TaskService\Roles;

class AdminRoles extends AbstractActionController
{
    /**
     * @var FormInterface
     */
    private $roleForm;

    /**
     * @var Roles
     */
    private $roleTaskService;

    public function __construct(FormInterface $roleForm, Roles $roleTaskService)
    {
        $this->roleForm = $roleForm;
        $this->roleTaskService = $roleTaskService;
    }

    public function indexAction()
    {
        /** @var Paginator $paginator */
        $paginator = $this->roleTaskService->getPaginator();
        $paginator->setItemCountPerPage(25);
        $paginator->setCurrentPageNumber($this->params()->fromQuery('page', 1));

        return new ViewModel([
            'roles' => $paginator,
        ]);
    }

    public function createAction()
    {
        if ($this->getRequest()->isPost()) {
            $this->roleForm->setData($this->getRequest()->getPost());

            if ($this->roleForm->isValid()) {
                $data = $this->roleForm->getData();

                $this->roleTaskService->persistFromArray($data);

                return $this->redirect()->toRoute('admin/usermanagement/roles');
            }
        }

        return new ViewModel([
            'roleForm' => $this->roleForm,
        ]);
    }

    public function updateAction()
    {
        $role = $this->roleTaskService->find($this->params('id'));

        if (!$role) {
            return $this->notFoundAction();
        }

        $this->roleForm->bind($role);

        if ($this->getRequest()->isPost()) {
            $this->roleForm->setData($this->getRequest()->getPost());

            if ($this->roleForm->isValid()) {
                $role = $this->roleForm->getData();

                $this->roleTaskService->persist($role);

                return $this->redirect()->toRoute('admin/usermanagement/roles');
            }
        }

        return new ViewModel([
            'role' => $role,
            'roleForm' => $this->roleForm,
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
