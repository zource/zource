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
use ZourceUser\Validator\IdentityNotExists;

class IdentityNotExistsFactory implements FactoryInterface, MutableCreationOptionsInterface
{
    /**
     * @var array
     */
    private $options = [];

    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $this->options = array_merge($this->options, [
            'entity_manager' => $serviceLocator->getServiceLocator()->get('doctrine.entitymanager.orm_default'),
        ]);

        $validator = new IdentityNotExists($this->options);

        $this->options = [];

        return $validator;
    }

    /**
     * Set creation options
     *
     * @param  array $options
     * @return void
     */
    public function setCreationOptions(array $options)
    {
        $this->options = $options;
    }
}
