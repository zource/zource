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

class ContactResourceFactory
{
    public function __invoke($services)
    {
        $entityManager = $services->get(EntityManager::class);

        return new ContactResource($entityManager);
    }
}
