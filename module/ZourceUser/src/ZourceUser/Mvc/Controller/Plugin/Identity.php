<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Mvc\Controller\Plugin;

use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use ZourceUser\Authentication\AuthenticationService;
use ZourceUser\Entity\Identity as IdentityEntity;

class Identity extends AbstractPlugin
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var AuthenticationService
     */
    private $authenticationService;

    public function __construct(EntityManager $entityManager, AuthenticationService $authenticationService)
    {
        $this->entityManager = $entityManager;
        $this->authenticationService = $authenticationService;
    }

    public function __invoke($id = null)
    {
        if ($id) {
            return $this->getEntity($id);
        }

        return $this->authenticationService->getIdentityEntity();
    }

    private function getEntity($id)
    {
        $account = $this->entityManager->getRepository(IdentityEntity::class);

        return $account->find($id);
    }
}
