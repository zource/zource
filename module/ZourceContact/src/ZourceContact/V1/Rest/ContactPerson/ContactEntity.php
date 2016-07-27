<?php
namespace ZourceContact\V1\Rest\ContactPerson;

use ZourceContact\Entity\Person;

class ContactEntity
{
    public $id;
    public $firstName;

    public function __construct(Person $person)
    {
        $this->id = $person->getId();
        $this->firstName = $person->getFirstName();
    }
}
