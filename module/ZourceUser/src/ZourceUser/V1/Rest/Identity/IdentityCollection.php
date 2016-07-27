<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\V1\Rest\Identity;

use ZourceApplication\Paginator\AbstractProxy;
use ZourceContact\V1\Rest\Contact\ContactEntity;
use ZourceUser\Entity\Account;
use ZourceUser\V1\Rest\Account\AccountEntity;

class IdentityCollection extends AbstractProxy
{
    protected function build($key, $value)
    {
        $entity = new IdentityEntity();
        $entity->id = $value->getId();
        $entity->account = $this->buildAccount($value->getAccount());
        $entity->directory = $value->getDirectory();
        $entity->identity = $value->getIdentity();

        return $entity;
    }

    private function buildAccount(Account $account)
    {
        $entity = new AccountEntity();
        $entity->id = $account->getId();
        $entity->creationDate = $account->getCreationDate();
        $entity->status = $account->getStatus();

        return $entity;
    }
}
