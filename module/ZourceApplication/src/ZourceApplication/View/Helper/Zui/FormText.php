<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\View\Helper\Zui;

use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\FormText as BaseFormText;

class FormText extends BaseFormText
{
    public function render(ElementInterface $element)
    {
        $result = '<div class="zui-field-group">';
        $result .= $this->getView()->formLabel($element);
        $result .= parent::render($element);
        $result .= $this->getView()->zourceFormDescription($element);
        $result .= $this->getView()->formElementErrors($element);
        $result .= '</div>';

        return $result;
    }
}
