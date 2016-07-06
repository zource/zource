<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Authentication\Adapter\Service;

use InvalidArgumentException;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\Exception;

class PluginManager extends AbstractPluginManager
{
    protected $shareByDefault = false;

    public function validatePlugin($plugin)
    {
        if (!$plugin instanceof AdapterInterface) {
            throw new InvalidArgumentException(sprintf(
                '%s can only create instances of %s; %s is invalid',
                get_class($this),
                $this->instanceOf,
                (is_object($plugin) ? get_class($plugin) : gettype($plugin))
            ));
        }
    }
}
