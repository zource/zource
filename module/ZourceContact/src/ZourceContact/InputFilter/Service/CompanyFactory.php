<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceContact\InputFilter\Service;

use Zend\InputFilter\Factory;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CompanyFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $inputFilterPluginManager = $serviceLocator->getServiceLocator()->get('InputFilterManager');

        /** @var array $config */
        $config = $serviceLocator->getServiceLocator()->get('Config');
        $types = $config['zource_contact_fields']['company'];
        $inputFilterConfig = $this->createConfig($types);

        /** @var Factory $inputFilterFactory */
        $inputFilterFactory = new Factory($inputFilterPluginManager);
        return $inputFilterFactory->createInputFilter($inputFilterConfig);
    }

    private function createConfig($types)
    {
        $result = [];

        foreach ($types as $fieldName => $fieldOptions) {
            if (!array_key_exists('input_filter_options', $fieldOptions)) {
                $fieldOptions['input_filter_options'] = [];
            }

            $result[$fieldName] = $fieldOptions['input_filter_options'];
        }

        return $result;
    }
}
