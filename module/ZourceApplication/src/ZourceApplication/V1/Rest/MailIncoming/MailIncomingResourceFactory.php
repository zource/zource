<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\V1\Rest\MailIncoming;

use ZourceApplication\TaskService\EmailServers;

class MailIncomingResourceFactory
{
    public function __invoke($services)
    {
        /** @var EmailServers $emailServers */
        $emailServers = $services->get(EmailServers::class);

        return new MailIncomingResource($emailServers);
    }
}
