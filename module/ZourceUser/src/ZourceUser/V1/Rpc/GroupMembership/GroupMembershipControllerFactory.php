<?php
namespace ZourceUser\V1\Rpc\GroupMembership;

use Doctrine\ORM\EntityManager;

class GroupMembershipControllerFactory
{
    public function __invoke($controllers)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $controllers->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        return new GroupMembershipController($entityManager);
    }
}
