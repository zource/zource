<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\View\Helper;

use Zend\View\Helper\AbstractHelper;
use ZourceApplication\Entity\Gadget;
use ZourceApplication\Entity\GadgetContainer as GadgetContainerObject;

class GadgetContainer extends AbstractHelper
{
    public function __invoke(GadgetContainerObject $gadgetContainer, array $options = [])
    {
        $html = sprintf(
            '<div class="zui-gadgets" data-zource-container-layout="%s" data-zource-empty-msg="%s">',
            $this->getView()->escapeHtmlAttr($gadgetContainer->getLayout()),
            $this->getView()->escapeHtmlAttr('No gadgets added yet.')
        );

        $html .= $this->renderColumns($gadgetContainer);
        $html .= '</div>';

        return $html;
    }

    private function renderColumns($gadgetContainer)
    {
        $columns = $gadgetContainer->getColumns();

        $html = '';

        foreach ($columns as $index => $columnWidth) {
            $gadgets = $gadgetContainer->getGadgetsForColumn($index);

            $html .= sprintf('<div class="zui-gadget-column" style="width: %d%%;">', $columnWidth);
            $html .= $this->renderGadgets($gadgets);
            $html .= '</div>';
        }

        return $html;
    }

    private function renderEmptyContainer()
    {
        return '<div class="zui-gadget zui-gadget-empty">No gadgets added yet.</div>';
    }

    private function renderGadgets(array $gadgets)
    {
        $html = '';

        if (!$gadgets) {
            $html .= $this->renderEmptyContainer();
        } else {
            foreach ($gadgets as $gadget) {
                $html .= $this->renderGadget($gadget);
            }
        }

        return $html;
    }

    private function renderGadget(Gadget $gadget)
    {
        $html = sprintf(
            '<div class="zui-gadget" data-zource-gadget-type="%s">',
            $this->getView()->escapeHtmlAttr($gadget->getType())
        );

        return $html . '</div>';
    }
}
