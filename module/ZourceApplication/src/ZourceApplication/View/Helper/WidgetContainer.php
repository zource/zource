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
    public function __invoke(WidgetContainerObject $widgetContainer)
    {
        $html = '<div class="zui-gadgets">';

        if ($widgetContainer->getWidgets()->count() === 0) {
            $html .= $this->renderEmptyContainer();
        } else {
            $html .= $this->renderColumns($widgetContainer);
        }

        $html .= '</div>';

        return $html;
    }

    private function renderEmptyContainer()
    {
        $html = '';

        $html .= '<div class="zui-gadgets-empty">No widgets found.</div>';

        return $html;
    }

    private function renderColumns($widgetContainer)
    {
        $html = '';
        $columns = $widgetContainer->getColumns();

        foreach ($columns as $index => $columnWidth) {
            $widgets = $widgetContainer->getWidgetsForColumn($index);

            $html .= '<div class="zui-gadget-column" style="width: ' . $columnWidth . '%;">';

            foreach ($widgets as $widget) {
                $html .= $this->renderWidget($widget);
            }

            $html .= '</div>';
        }

        return $html;
    }

    private function renderWidget(Widget $widget)
    {
        $html = sprintf(
            '<div class="zui-gadget" data-zource-gadget-type="%s" data-zource-gadget-options="%s">',
            $this->getView()->escapeHtmlAttr($widget->getType()),
            $this->getView()->escapeHtmlAttr(json_encode($widget->getOptions()))
        );

        $html .= '</div>';

        return $html;
    }
}
