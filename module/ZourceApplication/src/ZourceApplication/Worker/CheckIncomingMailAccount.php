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

class CheckIncomingMailAccount extends AbstractIncomingMailWorker
{
    public function run(Context $context)
    {
        $account = $context->getParam('account');
        if (!$account) {
            $context->getLogger()->debug('No account provided, stopping job.');
            return;
        }

        $mail = $this->getStorage($account);
        $mailCount = $mail->countMessages();

        // We only check the latest 'n' messages, assumption that no more than this
        // amount of messages come in per day.
        $messagesToCheck = 100;
        $lastMessageIndex = max(1, $mailCount - $messagesToCheck);

        $context->getLogger()->debug(sprintf(
            'Found %d messages, checking latest %d messages',
            $mailCount,
            $messagesToCheck
        ));

        for ($messageIndex = $mailCount; $messageIndex >= $lastMessageIndex; --$messageIndex) {
            $job = new Job(CheckIncomingMailMessage::class, [
                'account' => $account,
                'message' => $messageIndex,
            ]);

            $context->getDaemon()->enqueue($job);
        }
    }
}
