<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\V1\Rest\MailIncoming;

class MailIncomingEntity
{
    public $id;
    public $type;
    public $hostname;
    public $port;
    public $username;
    public $ssl;

    public function __construct(array $item)
    {
        $this->id = $item['id'];
        $this->type = $item['type'];
        $this->hostname = $item['hostname'];
        $this->port = $item['port'];
        $this->username = $item['username'];
        $this->ssl = $item['ssl'];
    }
}
