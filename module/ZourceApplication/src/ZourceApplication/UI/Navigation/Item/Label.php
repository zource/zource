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
    public function render(array $item)
    {
        $options = empty($item['options']) ? [] : $item['options'];

        $locale = empty($options['locale']) ? null : $options['locale'];
        $textDomain = empty($options['text_domain']) ? null : $options['text_domain'];
        $label = $this->getView()->translate($options['label'], $textDomain, $locale);
        $title = empty($options['title']) ? $label : $this->getView()->translate($options['title']);

        $routeParams = empty($options['route_params']) ? [] : $options['route_params'];
        $routeOptions = empty($options['route_options']) ? [] : $options['route_options'];
        $url = $this->getView()->url($options['route'], $routeParams, $routeOptions);

        return sprintf('<li><a href="%s" title="%s">%s</a></li>', $url, $title, $label);
    }
}
