<?php
namespace ZourceContact\V1\Rest\Contact;

class ContactResourceFactory
{
    public function __invoke($services)
    {
        $entityManager = $services->get('doctrine.entitymanager.orm_default');

        return new ContactResource($entityManager);
    }
}
