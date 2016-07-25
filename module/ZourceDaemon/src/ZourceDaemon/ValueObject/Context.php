<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceDaemon\ValueObject;

use Zend\Log\Logger;
use ZourceDaemon\TaskService\Daemon;

class Context
{
    private $daemon;
    private $logger;
    private $params;

    public function __construct(Daemon $daemon, Logger $logger, array $params)
    {
        $this->daemon = $daemon;
        $this->logger = $logger;
        $this->params = $params;
    }

    /**
     * @return Daemon
     */
    public function getDaemon()
    {
        return $this->daemon;
    }

    /**
     * @return Logger
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    public function getParam($name, $defaultValue = null)
    {
        if (!array_key_exists($name, $this->params)) {
            return $defaultValue;
        }

        return $this->params[$name];
    }
}
