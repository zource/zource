<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\UI\Navigation\Item;

interface ItemInterface
{
    /**
     * Checks if the item is part of a list.
     *
     * @return bool Returns true when the item is part of a list; false otherwise.
     */
    public function isPartOfList();

    /**
     * Renders the item.
     *
     * @param array $item The item representation to render.
     * @return string
     */
    public function render(array $item);
}
