<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\View\Helper;

use Zend\Form\Element;
use Zend\View\Helper\AbstractHelper;

class FormDescription extends AbstractHelper
{
    public function __invoke(Element $element)
    {
        $description = $element->getOption('description');
        if (!$description) {
            return '';
        }

        return sprintf('<div class="zui-description">%s</div>', $this->getView()->translate($description));
    }
}
