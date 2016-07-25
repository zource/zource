<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\TaskService;

use Zend\Config\Writer\PhpArray;

class EmailServers
{
    const PATH = 'config/autoload/zource.mail.local.php';
    const KEY_INCOMING = 'zource_mail_incoming';
    const KEY_OUTGOING = 'zource_mail_outgoing';

    private $incoming;
    private $outgoing;

    public function __construct($incoming, $outgoing)
    {
        $this->incoming = $incoming;
        $this->outgoing = $outgoing;
    }

    public function getIncomingAccounts()
    {
        return $this->incoming['accounts'];
    }

    public function getOutgoingServers()
    {
        return $this->outgoing['servers'];
    }

    public function findIncoming($id)
    {
        if (!array_key_exists($id, $this->incoming['accounts'])) {
            return null;
        }

        return $this->incoming['accounts'][$id];
    }

    public function findOutgoing($id)
    {
        if (!array_key_exists($id, $this->outgoing['servers'])) {
            return null;
        }

        return $this->outgoing['servers'][$id];
    }

    public function persistIncomingFromArray(array $data, $id = null)
    {
        if ($id === null) {
            $id = count($this->incoming['accounts']);
        }

        $this->incoming['accounts'][$id] = [
            'type' => $data['type'],
            'hostname' => $data['hostname'],
            'port' => $data['port'],
            'username' => $data['username'],
            'password' => $data['password'],
            'ssl' => $data['ssl'] ? $data['ssl'] : false,
        ];

        $this->persist();
    }

    public function persistOutgoingFromArray(array $data, $id = null)
    {
        if ($id === null) {
            $id = count($this->outgoing['servers']);
        }

        $this->outgoing['servers'][$id] = [
            'type' => $data['type'],
            'hostname' => $data['hostname'],
            'port' => $data['port'],
            'username' => $data['username'],
            'password' => $data['password'],
        ];

        $this->persist();
    }

    public function removeIncomingKey($id)
    {
        unset($this->incoming['accounts'][$id]);

        $this->persist();
    }

    public function removeOutgoingKey($id)
    {
        unset($this->outgoing['servers'][$id]);

        $this->persist();
    }

    private function persist()
    {
        $this->incoming['accounts'] = array_values($this->incoming['accounts']);
        $this->outgoing['servers'] = array_values($this->outgoing['servers']);

        $writer = new PhpArray();
        $writer->toFile(self::PATH, [
            self::KEY_INCOMING => $this->incoming,
            self::KEY_OUTGOING => $this->outgoing,
        ]);
    }
}
