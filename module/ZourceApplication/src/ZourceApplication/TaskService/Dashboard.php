<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\TaskService;

use Doctrine\ORM\EntityManager;
use DoctrineModule\Paginator\Adapter\Selectable;
use Zend\Paginator\Paginator;
use ZourceApplication\Entity\Dashboard as DashboardEntity;
use ZourceUser\Entity\AccountInterface;

class Dashboard
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function find($id)
    {
        $repository = $this->entityManager->getRepository(DashboardEntity::class);

        return $repository->find($id);
    }

    public function findAll()
    {
        $repository = $this->entityManager->getRepository(DashboardEntity::class);

        return $repository->findAll();
    }

    public function getPaginator()
    {
        $repository = $this->entityManager->getRepository(DashboardEntity::class);

        $adapter = new Selectable($repository);

        return new Paginator($adapter);
    }

    public function getAccountDashboard(AccountInterface $account)
    {
        $dashboard = null;
        $dashboardId = $account->getProperty('dashboard');

        if ($dashboardId) {
            $repository = $this->entityManager->getRepository(DashboardEntity::class);

            $dashboard = $repository->find($dashboardId);
        }

        if (!$dashboard) {
            $dashboard = new DashboardEntity($account, 'Dashboard');

            $account->setProperty('dashboard', $dashboard->getId()->toString());

            $this->entityManager->persist($dashboard);
            $this->entityManager->flush();
        }

        return $dashboard;
    }

    public function selectDashboard($account, $dashboard)
    {
        $account->setProperty('dashboard', $dashboard->getId()->toString());

        $this->entityManager->flush();
    }

    public function persist(DashboardEntity $dashboard)
    {
        $this->entityManager->persist($dashboard);
        $this->entityManager->flush($dashboard);
    }

    public function persistFromArray(AccountInterface $account, $data)
    {
        $dashboard = new DashboardEntity($account, $data['name']);

        $this->persist($dashboard);
    }

    public function remove(DashboardEntity $dashboard)
    {
        $this->entityManager->remove($dashboard);
        $this->entityManager->flush($dashboard);
    }
}
