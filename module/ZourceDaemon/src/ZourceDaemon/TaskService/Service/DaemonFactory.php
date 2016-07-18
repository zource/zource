<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceDaemon\TaskService\Service;

use Pheanstalk\Pheanstalk;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZourceDaemon\TaskService\Daemon;

class DaemonFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $config = $config['zource_daemon'];

        $pheanstalk = new Pheanstalk($config['host'], $config['port'], $config['timeout']);

        foreach ($config['tubes'] as $tube) {
            $pheanstalk->watch($tube);
        }

        $pheanstalk->ignore('default');

        return new Daemon($pheanstalk, $config['lifetime'], $config['interval']);
    }
}


