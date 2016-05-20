<?php
namespace ZourceUser\V1\Rpc\GroupMembership;

use Doctrine\ORM\EntityManager;
use Exception;
use Zend\Mvc\Controller\AbstractActionController;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\ContentNegotiation\ViewModel;
use ZourceUser\Entity\AccountInterface;
use ZourceUser\V1\Rest\Group\GroupEntity;

class GroupMembershipController extends AbstractActionController
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function groupMembershipAction()
    {
        /** @var AccountInterface $account */
        $account = $this->entityManager->getRepository(AccountInterface::class)->find($this->bodyParam('account'));
        if (!$account) {
            return new ApiProblem(404, 'The account could not be found.');
        }

        /** @var GroupEntity $group */
        $group = $this->entityManager->getRepository(GroupEntity::class)->find($this->bodyParam('group'));
        if (!$group) {
            return new ApiProblem(404, 'The group could not be found.');
        }

        if ($this->getRequest()->getMethod() === 'POST' && !$account->getGroups()->contains($group)) {
            $account->getGroups()->add($group);
        } elseif ($this->getRequest()->getMethod() === 'DELETE' && $account->getGroups()->contains($group)) {
            $account->getGroups()->removeElement($group);
        }

        try {
            $this->entityManager->beginTransaction();

            $this->entityManager->persist($account);
            $this->entityManager->flush();

            $this->entityManager->commit();
        } catch (Exception $e) {
            $this->entityManager->rollback();

            return new ApiProblemResponse(new ApiProblem(500, $e->getMessage(), null, null, [
                'exception' => $e,
            ]));
        }

        return new ViewModel([
            'group' => $group->getId(),
            'account' => $account->getId(),
        ]);
    }
}
