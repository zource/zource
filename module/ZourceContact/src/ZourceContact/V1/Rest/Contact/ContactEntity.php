<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceContact\V1\Rest\Contact;

use ZourceContact\Entity\AbstractContact;
use ZourceContact\Entity\Person;

class ContactEntity
{
    public $id;
    public $type;
    public $creationDate;
    public $lastUpdated;
    public $displayName;

    public function __construct(AbstractContact $contact)
    {
        $this->id = $contact->getId();
        $this->type = $contact instanceof Person ? 'person' : 'company';
        $this->creationDate = $contact->getCreationDate();
        $this->lastUpdated = $contact->getLastUpdated();
        $this->displayName = $contact->getDisplayName();
    }
}
