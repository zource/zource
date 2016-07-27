<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\V1\Rest\Session;

use ZourceApplication\Entity\Session;

class SessionEntity
{
    public $sessionId;
    public $creationDate;
    public $lastModified;
    public $lifetime;
    public $userAgent;
    public $remoteAddress;

    public function __construct(Session $value)
    {
        $this->sessionId = $value->getId();
        $this->creationDate = $value->getCreationDate();
        $this->lastModified = $value->getLastModified();
        $this->lifetime = $value->getLifetime();
        $this->userAgent = $value->getUserAgent();
        $this->remoteAddress = $value->getRemoteAddress();
    }
}
