<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\UI\Navigation\Item;

class Dropdown extends Label
{
    use LabelTrait;
    use UrlTrait;

    public function render(array $item)
    {
        // When no items are set, we act as if this is a normal label.
        // @todo Decide if we should throw an exception instead?
        if (empty($item['child_items'])) {
            return parent::render($item);
        }

        $options = $this->getOptions($item);

        $label = $this->getLabel($options);
        $title = $this->getTitle($options, $label);

        $id = uniqid();
        $boxId = 'dropdown-box-' . $id . '-dropdown';
        $anchorId = 'menu-option-' . $id;

        $anchorAttr = [];
        $anchorAttr['href'] = '';
        $anchorAttr['id'] = $anchorId;
        $anchorAttr['class'] = 'zui-button-dropdown';
        $anchorAttr['aria-haspopup'] = 'true';
        $anchorAttr['aria-controls'] = $boxId;
        $anchorAttr['aria-expanded'] = 'false';
        $anchorAttr['title'] = $title;

        $result = '<li>';
        $result .= sprintf(
            '<a %s>%s</a>',
            $this->createAttribs($anchorAttr),
            $label
        );
        $result .= $this->renderBox($anchorId, $boxId, $item);

        return $result . '</li>';
    }

    private function renderBox($anchorId, $boxId, array $item)
    {
        $boxAttr = [];
        $boxAttr['class'] = 'zui-dropdown-menu';
        $boxAttr['id'] = $boxId;
        $boxAttr['aria-hidden'] = 'true';
        $boxAttr['aria-describedby'] = $anchorId;

        return sprintf(
            '<div %s>%s</div>',
            $this->createAttribs($boxAttr),
            $this->getView()->zourceUiNav()->renderChildren($item['child_items'])
        );
    }

    private function createAttribs(array $attribs)
    {
        $result = [];

        foreach ($attribs as $name => $value) {
            $result[] = $name . '="' . $this->getView()->escapeHtmlAttr($value) . '"';
        }

        return implode(' ', $result);
    }
}
