<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\UI\Navigation\Item;

class Header extends AbstractItem
{
    use LabelTrait;
    
    public function render(array $item)
    {
        $options = $this->getOptions($item);

        return sprintf(
            '<div class="zui-nav-heading"><strong>%s</strong></div>',
            $this->getLabel($options)
        );
    }

    public function isPartOfList()
    {
        return false;
    }
}
