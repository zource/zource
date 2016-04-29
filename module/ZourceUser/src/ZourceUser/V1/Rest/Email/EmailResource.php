<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\V1\Rest\Email;

use ZourceApplication\Rest\AbstractDoctrineListener;
use ZourceUser\V1\Rest\Account\AccountEntity;

class EmailResource extends AbstractDoctrineListener
{
    /**
     * {@inheritDoc}
     */
    public function create($data)
    {
        $account = $this->getEntityManager()->getRepository(AccountEntity::class)->find($data->account);

        $data->account = $account;

        return parent::create($data);
    }
}
