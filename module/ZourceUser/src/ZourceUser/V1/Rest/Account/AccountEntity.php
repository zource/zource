<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\V1\Rest\Account;

use ZourceContact\Entity\Person;
use ZourceContact\V1\Rest\ContactCompany\ContactEntity as CompanyEntity;
use ZourceContact\V1\Rest\ContactPerson\ContactEntity as PersonEntity;
use ZourceUser\Entity\Account;

class AccountEntity
{
    public $id;
    public $creationDate;
    public $status;
    public $contact;

    public function __construct(Account $account)
    {
        $this->id = $account->getId();
        $this->creationDate = $account->getCreationDate();
        $this->status = $account->getStatus();

        $contact = $account->getContact();
        if ($contact instanceof Person) {
            $this->contact = new PersonEntity($contact);
        } else {
            $this->contact = new CompanyEntity($contact);
        }
    }
}
