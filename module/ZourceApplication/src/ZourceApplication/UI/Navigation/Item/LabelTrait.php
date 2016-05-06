<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\UI\Navigation\Item;

trait LabelTrait
{
    private function getLabel(array $options)
    {
        $locale = empty($options['locale']) ? null : $options['locale'];
        $textDomain = empty($options['text_domain']) ? null : $options['text_domain'];

        return $this->getView()->translate($options['label'], $textDomain, $locale);
    }

    private function getTitle(array $options, $defaultValue = null)
    {
        if (empty($options['title'])) {
            return $defaultValue;
        }

        $locale = empty($options['locale']) ? null : $options['locale'];
        $textDomain = empty($options['text_domain']) ? null : $options['text_domain'];

        return $this->getView()->translate($options['title'], $textDomain, $locale);
    }
}
