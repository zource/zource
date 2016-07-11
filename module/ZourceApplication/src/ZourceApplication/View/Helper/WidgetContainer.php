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
use ZourceApplication\Entity\Widget;
use ZourceApplication\Entity\WidgetContainer as WidgetContainerObject;

class WidgetContainer extends AbstractHelper
{
    public function __invoke(WidgetContainerObject $widgetContainer, array $options = [])
    {
        $html = sprintf(
            '<div class="zui-gadgets" data-zource-container-layout="%s">',
            $this->getView()->escapeHtmlAttr($widgetContainer->getLayout())
        );

        $html .= '<div class="zui-gadget zui-gadget-empty zui-gadget-empty-template" style="display: none;">No widgets added yet.</div>';

        $html .= $this->renderColumns($widgetContainer);
        $html .= '</div>';

        return $html;
    }

    private function renderColumns($widgetContainer)
    {
        $columns = $widgetContainer->getColumns();

        $html = '';

        foreach ($columns as $index => $columnWidth) {
            $widgets = $widgetContainer->getWidgetsForColumn($index);

            $html .= sprintf('<div class="zui-gadget-column" style="width: %d%%;">', $columnWidth);
            $html .= $this->renderWidgets($widgets);
            $html .= '</div>';
        }

        return $html;
    }

    private function renderEmptyContainer()
    {
        return '<div class="zui-gadget zui-gadget-empty">No widgets added yet.</div>';
    }

    private function renderWidgets(array $widgets)
    {
        $html = '';

        if (!$widgets) {
            $html .= $this->renderEmptyContainer();
        } else {
            foreach ($widgets as $widget) {
                $html .= $this->renderWidget($widget);
            }
        }

        return $html;
    }

    private function renderWidget(Widget $widget)
    {
        $html = sprintf(
            '<div class="zui-gadget" data-zource-gadget-type="%s">',
            $this->getView()->escapeHtmlAttr($widget->getType())
        );

        return $html . '</div>';
    }
}
