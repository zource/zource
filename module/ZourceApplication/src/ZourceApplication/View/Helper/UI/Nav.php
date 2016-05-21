<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\View\Helper\UI;

use InvalidArgumentException;
use Zend\View\Helper\AbstractHelper;
use ZourceApplication\Authorization\Condition\Service\PluginManager as ConditionPluginManager;
use ZourceApplication\UI\Navigation\Item\ItemInterface;
use ZourceApplication\UI\Navigation\Item\Service\PluginManager;

class Nav extends AbstractHelper
{
    private $itemManager;
    private $conditionManager;
    private $menus;
    private $ulClass;

    public function __construct(PluginManager $itemManager, ConditionPluginManager $conditionManager, array $menus)
    {
        $this->itemManager = $itemManager;
        $this->conditionManager = $conditionManager;
        $this->menus = $menus;
        $this->ulClass = 'zui-nav';
    }

    public function __invoke($name = null)
    {
        if (!$name) {
            return $this;
        }

        return $this->render($name);
    }

    public function render($name)
    {
        if (!array_key_exists($name, $this->menus)) {
            throw new InvalidArgumentException(sprintf('The navigation "%s" does not exists.', $name));
        }

        if (!$this->menus[$name] || !$this->menus[$name]['items']) {
            return '';
        }

        return $this->renderChildren($this->menus[$name]['items']);
    }

    public function renderChildren(array $items)
    {
        $result = '';

        // Sort the items before we render them.
        uasort($items, [$this, 'onSort']);

        // The amount of items that are rendered as part of a list. We use this
        // to determine if we need to open or close the list.
        $renderedItemCount = 0;

        foreach ($items as $item) {
            if (array_key_exists('conditions', $item) && !$this->isAllowed($item)) {
                continue;
            }

            /** @var ItemInterface $renderer */
            $renderer = $this->itemManager->get($item['type']);

            if ($renderer->isPartOfList() && $renderedItemCount === 0) {
                $result .= '<ul class="' . $this->ulClass . '">' . "\n";
            } elseif (!$renderer->isPartOfList() && $renderedItemCount > 0) {
                $result .= '</ul>' . "\n";
                $renderedItemCount = 0;
            }

            if ($renderer->isPartOfList()) {
                $renderedItemCount++;
            }

            $result .= $renderer->render($item) . "\n";
        }

        if ($renderedItemCount > 0) {
            $result .= '</ul>';
        }

        return $result;
    }

    private function onSort($lft, $rgt)
    {
        $lftPrio = array_key_exists('priority', $lft) ? $lft['priority'] : 0;
        $rgtPrio = array_key_exists('priority', $rgt) ? $rgt['priority'] : 0;

        if ($lftPrio < $rgtPrio) {
            return -1;
        } elseif ($lftPrio > $rgtPrio) {
            return 1;
        }

        return 0;
    }

    private function isAllowed(array $item)
    {
        foreach ($item['conditions'] as $key => $conditionItem) {
            $condition = $this->conditionManager->get($conditionItem['type'], $conditionItem['options']);
            
            $valid = $condition->isValid();

            if (array_key_exists('invert', $conditionItem) && $conditionItem['invert'] === true) {
                $valid = !$valid;
            }

            if (!$valid) {
                return false;
            }
        }

        return true;
    }
}
