<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceDaemon\Service;

use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\Exception;
use ZourceDaemon\Worker\WorkerInterface;

class WorkerManager extends AbstractPluginManager
{
    protected $autoAddInvokableClass = false;

    public function validatePlugin($plugin)
    {
        if (!$plugin instanceof WorkerInterface) {
            throw new Exception('Invalid plugin requested, does not implement ' . WorkerInterface::class);
        }
    }
}
