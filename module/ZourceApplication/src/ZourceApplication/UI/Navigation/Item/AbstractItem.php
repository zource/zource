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
use ZourceApplication\Authorization\Condition\Service\PluginManager;

abstract class AbstractItem implements ItemInterface
{
    /**
     * @var PluginManager
     */
    private $conditionManager;

    /**
     * @var RendererInterface
     */
    private $view;

    public function __construct(PluginManager $conditionManager, RendererInterface $view)
    {
        $this->conditionManager = $conditionManager;
        $this->view = $view;
    }

    protected function getConditionManager()
    {
        return $this->conditionManager;
    }

    protected function getView()
    {
        return $this->view;
    }
}
