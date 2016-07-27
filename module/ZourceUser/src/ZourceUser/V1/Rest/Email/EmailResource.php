<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\V1\Rest\Email;

use Doctrine\ORM\EntityManager;
use DoctrineModule\Paginator\Adapter\Selectable;
use ZF\Rest\AbstractResourceListener;
use ZourceUser\Entity\Email;

class EmailResource extends AbstractResourceListener
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function fetchAll($params = [])
    {
        $repository = $this->entityManager->getRepository(Email::class);

        $adapter = new Selectable($repository);

        return new EmailCollection($adapter);
    }
}
