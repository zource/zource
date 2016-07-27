<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\V1\Rest\Session;

use ZourceApplication\Paginator\AbstractProxy;

class SessionCollection extends AbstractProxy
{
    protected function build($key, $value)
    {
        $entity = new SessionEntity();
        $entity->sessionId = $value->getId();
        $entity->creationDate = $value->getCreationDate();
        $entity->lastModified = $value->getLastModified();
        $entity->lifetime = $value->getLifetime();
        $entity->userAgent = $value->getUserAgent();
        $entity->remoteAddress = $value->getRemoteAddress();

        return $entity;
    }
}
