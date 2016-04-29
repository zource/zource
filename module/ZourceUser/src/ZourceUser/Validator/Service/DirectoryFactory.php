<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Validator\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\MutableCreationOptionsInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZourceUser\Validator\Directory;

class DirectoryFactory implements FactoryInterface, MutableCreationOptionsInterface
{
    /**
     * @var array
     */
    private $options;

    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $validator = new Directory($this->options);

        $this->options = [];

        return $validator;
    }

    public function setCreationOptions(array $options)
    {
        $this->options = $options;
    }
}
