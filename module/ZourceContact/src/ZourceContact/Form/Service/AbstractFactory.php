<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceContact\Form\Service;

use RuntimeException;
use Zend\Form\Factory;
use Zend\Form\FormInterface;
use Zend\Hydrator\HydratorPluginManager;
use Zend\InputFilter\InputFilterPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

abstract class AbstractFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var InputFilterPluginManager $inputFilterManager */
        $inputFilterManager = $serviceLocator->get('InputFilterManager');

        /** @var array $config */
        $config = $serviceLocator->get('Config');
        $types = $config['zource_contact_fields'][$this->getConfigKey()];

        /** @var HydratorPluginManager $hydratorManager */
        $hydratorManager = $serviceLocator->get('HydratorManager');
        $hydrator = $hydratorManager->get($this->getHydratorName());

        $formFactory = new Factory($serviceLocator->get('FormElementManager'));

        /** @var FormInterface $form */
        $form = $formFactory->createForm($this->createSpec($types, $config['zource_field_types']));
        $form->setInputFilter($inputFilterManager->get($this->getInputFilterName()));
        $form->setHydrator($hydrator);

        return $form;
    }

    abstract protected function getConfigKey();
    abstract protected function getHydratorName();
    abstract protected function getInputFilterName();

    private function createSpec($types, $fieldTypes)
    {
        $result = [
            'elements' => [
                'token' => [
                    'spec' => [
                        'type' => 'Csrf',
                        'name' => 'token',
                    ],
                ],
                'submit' => [
                    'spec' => [
                        'type' => 'Submit',
                        'name' => 'submit',
                        'attributes' => [
                            'value' => 'Save',
                        ],
                    ],
                ],
            ],
        ];

        foreach ($types as $fieldName => $field) {
            $type = $field['type'];

            if (!array_key_exists($type, $fieldTypes)) {
                throw new RuntimeException(sprintf('The type "%s" does not exists.', $type));
            }

            if (!array_key_exists('form_element', $fieldTypes[$type])) {
                throw new RuntimeException(sprintf(
                    'The option "form_element" is not configured for type "%s".',
                    $type
                ));
            }

            if (!array_key_exists('form_element_options', $fieldTypes[$type])) {
                $fieldTypes[$type]['form_element_options'] = [];
            }

            if (!array_key_exists('form_element_options', $field)) {
                $field['form_element_options'] = [];
            }

            $fieldOptions = array_merge(
                $fieldTypes[$type]['form_element_options'],
                $field['form_element_options']
            );

            $result['elements'][$fieldName] = [
                'spec' => [
                    'type' => $fieldTypes[$type]['form_element'],
                    'name' => $fieldName,
                    'options' => $fieldOptions,
                ],
            ];
        }

        return $result;
    }
}
