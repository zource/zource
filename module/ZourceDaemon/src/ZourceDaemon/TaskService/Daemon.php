<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceDaemon\TaskService;

use Exception;
use Pheanstalk\PheanstalkInterface;
use RuntimeException;
use Zend\Log\LoggerInterface;
use ZourceDaemon\Service\WorkerManager;
use ZourceDaemon\ValueObject\Job;
use ZourceDaemon\Worker\WorkerInterface;

class Daemon
{
    /**
     * @var PheanstalkInterface
     */
    private $pheanstalk;

    /**
     * @var WorkerManager
     */
    private $workerManager;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var int
     */
    private $lifetime;

    /**
     * @var int
     */
    private $interval;

    public function __construct(
        PheanstalkInterface $pheanstalk,
        WorkerManager $workerManager,
        LoggerInterface $logger,
        $lifetime,
        $interval
    ) {
        $this->pheanstalk = $pheanstalk;
        $this->workerManager = $workerManager;
        $this->logger = $logger;
        $this->lifetime = $lifetime;
        $this->interval = $interval;
    }

    public function run()
    {
        $endTime = time() + $this->lifetime;

        $this->logger->info(sprintf('Started listening with a lifetime of %d seconds.', $this->lifetime));

        while (time() < $endTime) {
            try {
                /** @var \Pheanstalk\Job $job */
                $job = $this->pheanstalk->reserve(1);
            } catch (Exception $exception) {
            }

            if ($job) {
                $this->logger->info(sprintf('Reserved job #%d: %s', $job->getId(), $job->getData()));

                try {
                    $data = json_decode($job->getData(), true);

                    /** @var WorkerInterface $worker */
                    $worker = $this->workerManager->get($data['worker'], $data['params']);
                    $worker->run();

                    $this->logger->info(sprintf('Finished job #%d', $job->getId()));
                    $this->pheanstalk->delete($job);
                } catch (Exception $exception) {
                    $this->logger->emerg('Failed to execute job #' . $job->getId(), [
                        'exception' => $exception,
                    ]);
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

    public function getStats()
    {
        $stats = $this->pheanstalk->stats();

        return [
            'pid' => $stats['pid'],
            'hostname' => $stats['hostname'],
            'version' => $stats['version'],
            'uptime' => $stats['uptime'],
            'max-job-size' => $stats['max-job-size'],
        ];
    }

    public function getTubeStats()
    {
        $result = [];
        $tubes = $this->pheanstalk->listTubes();

        foreach ($tubes as $tubeName) {
            $stats = $this->pheanstalk->statsTube($tubeName);

            $result[] = [
                'name' => $tubeName,
                'buried' => $stats['current-jobs-buried'],
                'delayed' => $stats['current-jobs-delayed'],
                'ready' => $stats['current-jobs-ready'],
                'reserved' => $stats['current-jobs-reserved'],
                'urgent' => $stats['current-jobs-urgent'],
                'waiting' => $stats['current-waiting'],
                'total' => $stats['total-jobs'],
            ];
        }

        return $result;
    }
}


