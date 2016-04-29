<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceProject\V1\Rest\Project;

use Doctrine\ORM\EntityManager;

class ProjectResourceFactory
{
    public function __invoke($services)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $services->get('doctrine.entitymanager.orm_default');

        return new ProjectResource($entityManager);
    }
}
