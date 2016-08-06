<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\V1\Rest\MailIncoming;

use Zend\Paginator\Adapter\ArrayAdapter;
use ZF\Rest\AbstractResourceListener;
use ZourceApplication\TaskService\EmailServers;

class MailIncomingResource extends AbstractResourceListener
{
    /**
     * @var EmailServers
     */
    private $emailServers;

    /**
     * Initializes a new instance of this class.
     *
     * @param EmailServers $emailServers
     */
    public function __construct(EmailServers $emailServers)
    {
        $this->emailServers = $emailServers;
    }

    public function create($data)
    {
        return $this->emailServers->persistIncomingFromArray((array)$data);
    }

    public function fetch($id)
    {
        $incomingAccount = $this->emailServers->findIncoming($id);

        if (!$incomingAccount) {
            return null;
        }

        $incomingAccount['id'] = $id;

        return new MailIncomingEntity($incomingAccount);
    }

    public function fetchAll($params = [])
    {
        $adapter = new ArrayAdapter($this->emailServers->getIncomingAccounts());

        return new MailIncomingCollection($adapter);
    }
}
