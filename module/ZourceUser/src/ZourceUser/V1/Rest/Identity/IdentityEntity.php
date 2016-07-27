<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\V1\Rest\Identity;

use ZourceUser\V1\Rest\Account\AccountEntity;

class IdentityEntity
{
    public $id;
    public $account;
    public $directory;
    public $identity;
    
    public function __construct($identity)
    {
        $this->id = $identity->getId();
        $this->account = new AccountEntity($identity->getAccount());
        $this->directory = $identity->getDirectory();
        $this->identity = $identity->getIdentity();
    }
}
