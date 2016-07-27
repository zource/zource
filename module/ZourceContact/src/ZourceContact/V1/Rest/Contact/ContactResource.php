<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceContact\V1\Rest\Contact;

use Doctrine\ORM\EntityManager;
use DoctrineModule\Paginator\Adapter\Selectable;
use ZF\Rest\AbstractResourceListener;
use ZourceContact\Entity\AbstractContact;

class ContactResource extends AbstractResourceListener
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function fetch($id)
    {
        $repository = $this->entityManager->getRepository(AbstractContact::class);
        $contact = $repository->find($id);

        if (!$contact) {
            return null;
        }

        return new ContactEntity($contact);
    }

    public function fetchAll($params = array())
    {
        $repository = $this->entityManager->getRepository(AbstractContact::class);

        $adapter = new Selectable($repository);

        return new ContactCollection($adapter);
    }
}
