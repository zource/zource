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
use ZourceApplication\UI\Navigation\Item\Service\PluginManager;

class Nav extends AbstractHelper
{
    private $itemManager;
    private $conditionManager;
    private $config;

    public function __construct(PluginManager $itemManager, ConditionPluginManager $conditionManager, array $config)
    {
        $this->itemManager = $itemManager;
        $this->conditionManager = $conditionManager;
        $this->config = $config;
    }

    public function __invoke($name)
    {
        if (!array_key_exists($name, $this->config)) {
            throw new InvalidArgumentException(sprintf('The navigation "%s" does not exists.', $name));
        }

        if (!$this->config[$name] || !$this->config[$name]['items']) {
            return '';
        }

        uasort($this->config[$name]['items'], [$this, 'onSort']);

        $result = '<ul class="zui-nav">';

        foreach ($this->config[$name]['items'] as $key => $item) {
            if (array_key_exists('conditions', $item) && !$this->isAllowed($item)) {
                continue;
            }

            $renderer = $this->itemManager->get($item['type']);

            $result .= $renderer->render($item);
        }

        return $result . '</ul>';
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
