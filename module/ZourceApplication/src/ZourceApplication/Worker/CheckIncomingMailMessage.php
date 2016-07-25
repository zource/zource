<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\Worker;

use ZourceApplication\TaskService\IncomingMailHandlerInterface;
use ZourceDaemon\ValueObject\Context;

class CheckIncomingMailMessage extends AbstractIncomingMailWorker
{
    private $handlers;

    public function __construct()
    {
        $this->handlers = [];
    }

    public function addHandler(IncomingMailHandlerInterface $handler)
    {
        $this->handlers[] = $handler;
    }

    public function run(Context $context)
    {
        $account = $context->getParam('account');
        if (!$account) {
            $context->getLogger()->debug('No account provided, stopping job.');
            return;
        }

        // Gracefully sleep a little a bit to not flood the server.
        sleep(1);

        $mail = $this->getStorage($account);

        $messageNum = $context->getParam('message');
        $message = $mail->getMessage($messageNum);

        if (!$message) {
            $context->getLogger()->debug(sprintf('Could not find message with index %d, stopping job.', $messageNum));
            return;
        }

        $context->getLogger()->debug(sprintf('Found %d parts in this message.', $message->countParts()));

        $handled = false;

        /** @var IncomingMailHandlerInterface $handler */
        foreach ($this->handlers as $handler) {
            if ($handler->canHandle($message)) {
                $handler->handle($message);
                $handled = true;
            }
        }

        $context->getLogger()->info($handled ? 'The message was handled.' : 'No valid handler found for message.');
        return;


        for ($i = 1; $i <= $message->countParts(); ++$i) {
            $part = $message->getPart($i);
            $contentType = strtok($part->contentType, ';');

            switch (true) {
                case $contentType === 'multipart/alternative':
                    break;

                case substr($contentType, 0, 6) === 'image/':
                    //$this->downloadAttachment();
                    break;

                default:
                    $context->getLogger()->info('Ignoring non-implemented Content-Type: ' . $contentType);
                    exit;
                    break;
            }
        }
    }
}
