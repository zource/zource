<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\UI\Navigation\Item;

class Label extends AbstractItem
{
    use LabelTrait;
    use UrlTrait;

    public function render(array $item)
    {
        $options = $this->getOptions($item);

        $label = $this->getLabel($options);
        $title = $this->getTitle($options, $label);
        $url = $this->getUrl($options);

        return sprintf('<li><a href="%s" title="%s">%s</a></li>', $url, $title, $label);
    }
}
