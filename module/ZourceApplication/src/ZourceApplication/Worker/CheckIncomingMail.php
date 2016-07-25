<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\Worker;

use ZourceDaemon\ValueObject\Context;
use ZourceDaemon\ValueObject\Job;
use ZourceDaemon\Worker\WorkerInterface;

class CheckIncomingMail implements WorkerInterface
{
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function run(Context $context)
    {
        foreach ($this->config['accounts'] as $account) {
            $job = new Job(CheckIncomingMailAccount::class, [
                'account' => $account,
            ]);

            $context->getDaemon()->enqueue($job);
        }
    }
}
