<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\View\Helper;

use Zend\Form\View\Helper\FormSelect;

class FormSelect2 extends FormSelect
{
    public function renderOptions(array $options, array $selectedOptions = [])
    {
        $html = parent::renderOptions($options, $selectedOptions);

        foreach ($selectedOptions as $value => $label) {
            $html .= sprintf(
                '<option value="%s" selected>%s</option>',
                $value,
                $label
            );
        }

        return $html;
    }
}
