<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceDaemon\TaskService;

use Pheanstalk\Pheanstalk;
use Pheanstalk\PheanstalkInterface;
use RuntimeException;
use ZourceDaemon\ValueObject\Job;

class Daemon
{
    /**
     * @var PheanstalkInterface
     */
    private $pheanstalk;

    /**
     * @var int
     */
    private $lifetime;

    /**
     * @var int
     */
    private $interval;

    public function __construct(PheanstalkInterface $pheanstalk, $lifetime, $interval)
    {
        $this->pheanstalk = $pheanstalk;
        $this->lifetime = $lifetime;
        $this->interval = $interval;
    }

    public function run()
    {
        $endTime = time() + $this->lifetime;

        while (time() < $endTime) {
            try {
                $job = $this->pheanstalk->reserve(1);
            } catch (Exception $e) {
            }

            if ($job) {
                try {
                    $data = json_decode($job->getData(), true);

                    $this->pheanstalk->delete($job);

                    var_dump($data);
                } catch (Exception $e) {
                    $this->pheanstalk->bury($job);
                }
            }

            usleep($this->interval);
        }
    }

    public function enqueue(Job $job)
    {
        if (!$this->pheanstalk) {
            throw new RuntimeException('The daemon is not connected.');
        }

        if (!$job->getTube()) {
            throw new RuntimeException('No tube provided so cannot add job');
        }

        $data = json_encode([
            'worker' => $job->getWorker(),
            'params' => $job->getParams(),
        ]);

        $this->pheanstalk->useTube($job->getTube())->put(
            $data,
            $job->getPriority(),
            $job->getDelay(),
            $job->getTimeToRun()
        );
    }

    public function dequeue()
    {
        $job = $this->pheanstalk->reserve(1);

        $data = json_decode($job->getData(), true);

        return $data;
    }
}


