<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Hydrator\Strategy;

use Doctrine\Common\Collections\ArrayCollection;
use Zend\Hydrator\Strategy\StrategyInterface;
use ZourceUser\TaskService\Group;

class Groups implements StrategyInterface
{
    /**
     * @var Group
     */
    private $groupTaskService;

    public function __construct(Group $groupTaskService)
    {
        $this->groupTaskService = $groupTaskService;
    }

    public function extract($value, $object = null)
    {
        $result = [];

        /** @var \ZourceUser\Entity\Group $group */
        foreach ($value as $group) {
            $result[$group->getId()->toString()] = $group->getName();
        }

        return $result;
    }

    public function hydrate($value, $data = null)
    {
        $result = new ArrayCollection();

        foreach ($value as $id) {
            $account = $this->groupTaskService->find($id);

            if ($account !== null) {
                $result[] = $account;
            }
        }

        return $result;
    }
}
