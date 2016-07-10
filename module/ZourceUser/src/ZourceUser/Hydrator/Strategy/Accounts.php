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
use ZourceUser\TaskService\Account;

class Accounts implements StrategyInterface
{
    /**
     * @var Account
     */
    private $accountTaskService;

    public function __construct(Account $accountTaskService)
    {
        $this->accountTaskService = $accountTaskService;
    }

    public function extract($value, $object = null)
    {
        $result = [];

        /** @var \ZourceUser\Entity\AccountInterface $account */
        foreach ($value as $account) {
            $result[$account->getId()->toString()] = $account->getContact()->getDisplayName();
        }

        return $result;
    }

    public function hydrate($value, $data = null)
    {
        $result = new ArrayCollection();

        foreach ($value as $id) {
            $account = $this->accountTaskService->find($id);

            if ($account !== null) {
                $result[] = $account;
            }
        }

        return $result;
    }
}
