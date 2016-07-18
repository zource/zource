<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceDaemon\ValueObject;

use Pheanstalk\PheanstalkInterface;

class Job
{
    /**
     * @var string
     */
    private $worker;

    /**
     * @var array
     */
    private $params;

    /**
     * @var string
     */
    private $tube;

    /**
     * @var int
     */
    private $priority;

    /**
     * @var int
     */
    private $delay;

    /**
     * @var int
     */
    private $timeToRun;

    public function __construct($worker, array $params = [])
    {
        $this->worker = $worker;
        $this->params = $params;
        $this->tube = 'zource';
        $this->priority = PheanstalkInterface::DEFAULT_PRIORITY;
        $this->delay = PheanstalkInterface::DEFAULT_DELAY;
        $this->timeToRun = PheanstalkInterface::DEFAULT_TTR;
    }

    /**
     * @return string
     */
    public function getWorker()
    {
        return $this->worker;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return string
     */
    public function getTube()
    {
        return $this->tube;
    }

    /**
     * @param string $tube
     */
    public function setTube($tube)
    {
        $this->tube = $tube;
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    /**
     * @return int
     */
    public function getDelay()
    {
        return $this->delay;
    }

    /**
     * @param int $delay
     */
    public function setDelay($delay)
    {
        $this->delay = $delay;
    }

    /**
     * @return int
     */
    public function getTimeToRun()
    {
        return $this->timeToRun;
    }

    /**
     * @param int $timeToRun
     */
    public function setTimeToRun($timeToRun)
    {
        $this->timeToRun = $timeToRun;
    }
}
