<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\UI\Navigation\Item;

use Zend\View\Renderer\RendererInterface;

abstract class AbstractItem implements ItemInterface
{
    /**
     * @var RendererInterface
     */
    private $view;

    public function __construct(RendererInterface $view)
    {
        $this->view = $view;
    }

    public function isPartOfList()
    {
        return true;
    }

    protected function getView()
    {
        return $this->view;
    }

    protected function getOptions(array $item)
    {
        return empty($item['options']) ? [] : $item['options'];
    }
}
