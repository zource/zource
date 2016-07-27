<?php
namespace ZourceContact\V1\Rest\ContactCompany;

use ZourceContact\Entity\Company;

class ContactEntity
{
    public $id;
    public $name;

    public function __construct(Company $company)
    {
        $this->id = $company->getId();
        $this->name = $company->getName();
    }
}
