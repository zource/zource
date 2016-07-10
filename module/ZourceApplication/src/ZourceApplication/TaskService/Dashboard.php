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

    public function findForAccount(AccountInterface $account)
    {
        $dashboard = null;
        $dashboardId = $account->getProperty('dashboard');

        if ($dashboardId) {
            $repository = $this->entityManager->getRepository(DashboardEntity::class);

            $dashboard = $repository->find($dashboardId);
        }

        if (!$dashboard) {
            $dashboard = new DashboardEntity('Dashboard');

            $account->setProperty('dashboard', $dashboard->getId()->toString());

            $this->entityManager->persist($dashboard);
            $this->entityManager->flush();
        }

        return $dashboard;
    }
}
