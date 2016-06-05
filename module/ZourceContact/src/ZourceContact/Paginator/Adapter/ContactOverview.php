<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceContact\Paginator\Adapter;

use Doctrine\DBAL\Connection;
use Ramsey\Uuid\Uuid;
use Zend\Paginator\Adapter\AdapterInterface;
use ZourceContact\ValueObject\ContactEntry;

class ContactOverview implements AdapterInterface
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var string
     */
    private $filter;

    public function __construct(Connection $connection, $filter = null)
    {
        $this->connection = $connection;
        $this->filter = $filter;
    }

    public function getItems($offset, $itemCountPerPage)
    {
        $sql = $this->getSql();
        $sql .= " ORDER BY display_name ASC";
        $sql .= sprintf(" LIMIT %d, %d", $offset, $itemCountPerPage);

        $statement = $this->connection->executeQuery($sql);
        $result = $statement->fetchAll();

        return array_map(function ($item) {
            return new ContactEntry(
                $item['type'],
                Uuid::fromBytes($item['id']),
                $item['display_name']
            );
        }, $result);
    }

    public function count()
    {
        $sql = "SELECT COUNT(1) AS amount FROM (" . $this->getSql() . ") AS c";

        $statement = $this->connection->executeQuery($sql);

        return $statement->fetchColumn();
    }

    private function getSql()
    {
        switch ($this->filter) {
            case ContactEntry::TYPE_COMPANY:
                $sql = $this->getCompanySql();
                break;

            case ContactEntry::TYPE_PERSON:
                $sql = $this->getPersonSql();
                break;

            default:
                $sql = $this->getPersonSql() . ' UNION ' . $this->getCompanySql();
                break;
        }

        return $sql;
    }

    private function getCompanySql()
    {
        return "SELECT 'company' AS type, id, name AS display_name FROM contact_company";
    }

    private function getPersonSql()
    {
        return "SELECT 'person' AS type, id, CONCAT_WS(' ', first_name, last_name) AS display_name FROM contact_person";
    }
}
