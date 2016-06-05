<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceContact\View\Helper;

use RuntimeException;
use Zend\Form\Element\Radio;
use Zend\Form\ElementInterface;
use Zend\Form\FormInterface;
use Zend\View\Helper\AbstractHelper;

class ContactForm extends AbstractHelper
{
    private $fieldTypes;
    private $contactTypes;

    public function __construct(array $fieldTypes, $contactTypes)
    {
        $this->fieldTypes = $fieldTypes;
        $this->contactTypes = $contactTypes;
    }

    public function __invoke(FormInterface $form, $type)
    {
        $fields = $this->contactTypes[$type];

        $result = '';

        foreach ($fields as $fieldName => $fieldOptions) {
            $result .= $this->renderElement($form->get($fieldName), $fieldOptions);
        }

        return $result;
    }

    private function renderElement(ElementInterface $element, array $fieldOptions)
    {
        $fieldType = $this->fieldTypes[$fieldOptions['type']];

        if (array_key_exists('view_helper', $fieldType)) {
            $viewHelperName = $fieldType['view_helper'];
        } elseif (array_key_exists('view_helper', $fieldOptions)) {
            $viewHelperName = $fieldOptions['view_helper'];
        } else {
            throw new RuntimeException(sprintf(
                'No view helper configured for field "%s" of type "%s".',
                $element->getName(),
                $fieldOptions['type']
            ));
        }

        if (!array_key_exists('form_element_options', $fieldOptions)) {
            $fieldOptions['form_element_options'] = [];
        }


        if (strtolower($viewHelperName) === 'formradio') {
            $result = $this->renderRadio($element);
        } else {
            $plugin = $this->getView()->plugin($viewHelperName);

            $result = '<div class="zui-field-group">';

            if (array_key_exists('label', $fieldOptions['form_element_options'])) {
                $result .= $this->getView()->formLabel($element);
            }

            $result .= $plugin($element);
            $result .= $this->getView()->zourceFormDescription($element);
            $result .= $this->getView()->formElementErrors($element);
            $result .= '</div>';
        }

        return $result;
    }

    private function renderRadio(Radio $element)
    {
        $label = $this->getView()->translate($element->getLabel());

        $result = '<fieldset class="zui-group">';
        $result .= '<legend><span>' . $this->getView()->escapeHtml($label) . '</span></legend>';

        foreach ($element->getValueOptions() as $key => $value) {
            $id = uniqid('zui', false);

            $result .= '<div class="radio">';
            if ($element->getValue() == $key) {
                $checked = ' checked="checked"';
            } else {
                $checked = '';
            }

            $result .= sprintf(
                '<input class="radio" type="radio" name="%s" id="%s" value="%s"%s>',
                $this->getView()->escapeHtmlAttr($element->getName()),
                $this->getView()->escapeHtmlAttr($id),
                $this->getView()->escapeHtmlAttr($key),
                $checked
            );
            $result .= '<label for="' . $id . '">' . $this->getView()->escapeHtml($value) . '</label>';
            $result .= '</div>';
        }

        $result .= $this->getView()->zourceFormDescription($element);
        $result .= $this->getView()->formElementErrors($element);

        return $result . '</fieldset>';
    }
}
