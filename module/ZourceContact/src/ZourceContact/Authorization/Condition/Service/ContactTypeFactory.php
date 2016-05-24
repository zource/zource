<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceContact\Authorization\Condition\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\MutableCreationOptionsInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZourceContact\Authorization\Condition\ContactType;

class ContactTypeFactory implements FactoryInterface, MutableCreationOptionsInterface
{
    private $options;

    public function __construct()
    {
        $this->options = [];
    }

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options = $this->options;

        $this->options = [];

        return new ContactType($options, $serviceLocator->getServiceLocator()->get('ViewRenderer'));
    }

    public function setCreationOptions(array $options)
    {
        $this->options = $options;
    }
}
