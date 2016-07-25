<?php
namespace ZourceContact\V1\Rest\ContactPerson;

use ZourceContact\TaskService\Contact;

class ContactResourceFactory
{
    public function __invoke($services)
    {
        $contactTaskService = $services->get(Contact::class);

        return new ContactResource($contactTaskService);
    }
}
