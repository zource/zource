<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\Worker;

use RuntimeException;
use Zend\Mail\Storage\Imap;
use ZourceDaemon\Worker\WorkerInterface;

abstract class AbstractIncomingMailWorker implements WorkerInterface
{
    protected function getStorage(array $account)
    {
        switch ($account['type']) {
            case 'imap':
                $result = $this->buildImapStorage($account);
                break;

            default:
                throw new RuntimeException('Invalid storage type provided: ' . $account['type']);
        }

        return $result;
    }

    private function buildImapStorage($account)
    {
        return new Imap([
            'host' => $account['hostname'],
            'port' => $account['port'],
            'user' => $account['username'],
            'password' => $account['password'],
            'ssl' => $account['ssl'],
        ]);
    }
}
