<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\TaskService;

use Doctrine\DBAL\Driver\Connection;
use ZourceApplication\ValueObject\RemoteAddressEntry;

class RemoteAddressLookup
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function lookup($remoteAddress)
    {
        return null;//
        $query = "SELECT * FROM `ip2location_db3` WHERE INET_ATON(:ip) <= ip_to LIMIT 1";

        $result = $this->connection->fetchAssoc($query, [
            'ip' => $remoteAddress,
        ]);

        if ($result) {
            return new RemoteAddressEntry(
                $result['country_code'] === '-' ? null : $result['country_code'],
                $result['country_name'] === '-' ? null : $result['country_name'],
                $result['region_name'] === '-' ? null : $result['region_name'],
                $result['city_name'] === '-' ? null : $result['city_name']
            );
        }

        return null;
    }
}
