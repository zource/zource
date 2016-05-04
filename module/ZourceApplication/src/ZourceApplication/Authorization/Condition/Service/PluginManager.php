<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\Authorization\Condition\Service;

use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\Exception;
use Zend\ServiceManager\Exception\InvalidServiceException;
use ZourceApplication\Authorization\Condition\ConditionInterface;

class PluginManager extends AbstractPluginManager
{
    public function validatePlugin($instance)
    {
        if (!$instance instanceof ConditionInterface) {
            throw new InvalidServiceException(sprintf(
                '%s can only create instances of %s; %s is invalid',
                get_class($this),
                ConditionInterface::class,
                (is_object($instance) ? get_class($instance) : gettype($instance))
            ));
        }
    }
}
