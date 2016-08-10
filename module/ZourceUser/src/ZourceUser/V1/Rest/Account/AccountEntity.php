<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\V1\Rest\Account;

use RuntimeException;
use ZourceContact\Entity\Person;
use ZourceContact\V1\Rest\ContactCompany\ContactEntity as CompanyEntity;
use ZourceContact\V1\Rest\ContactPerson\ContactEntity as PersonEntity;
use ZourceUser\Entity\Account;
use ZourceUser\Entity\AccountInterface;

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

        switch ($account->getStatus()) {
            case AccountInterface::STATUS_ACTIVE:
                $this->status = 'active';
                break;

            case AccountInterface::STATUS_INACTIVE:
                $this->status = 'inactive';
                break;

            case AccountInterface::STATUS_INVITED:
                $this->status = 'invited';
                break;

            default:
                throw new RuntimeException('The account status could not be converted to a string.');
        }

        $contact = $account->getContact();
        if ($contact instanceof Person) {
            $this->contact = new PersonEntity($contact);
        } else {
            $this->contact = new CompanyEntity($contact);
        }
    }
}
