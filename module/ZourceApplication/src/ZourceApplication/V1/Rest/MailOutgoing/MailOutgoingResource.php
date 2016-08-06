<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\V1\Rest\MailOutgoing;

use Zend\Paginator\Adapter\ArrayAdapter;
use ZF\Rest\AbstractResourceListener;
use ZourceApplication\TaskService\EmailServers;

class MailOutgoingResource extends AbstractResourceListener
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

    public function fetch($id)
    {
        $account = $this->emailServers->findOutgoing($id);

        if (!$account) {
            return null;
        }

        $account['id'] = $id;

        return new MailOutgoingEntity($account);
    }

    public function fetchAll($params = [])
    {
        $adapter = new ArrayAdapter($this->emailServers->getOutgoingServers());

        return new MailOutgoingCollection($adapter);
    }
}
