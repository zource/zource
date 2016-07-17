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
    private $options;

    public function __construct()
    {
        $this->options = [];
    }

    public function __invoke(GadgetContainerObject $gadgetContainer, array $options)
    {
        $this->options = $options;

        $attribs = [];
        $attribs['class'] = 'zui-gadgets';
        $attribs['data-zource-container-load-url'] = $this->getView()->url($options['load_url']);
        $attribs['data-zource-container-update-container-url'] = $options['update_container_url'];
        $attribs['data-zource-container-layout'] = $gadgetContainer->getLayout();
        $attribs['data-zource-empty-msg'] = 'No gadgets added yet.';

        $html = sprintf('<div %s>', $this->renderAttribs($attribs));
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
        return '<div class="zui-gadget-empty">No gadgets added yet.</div>';
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
        $view = $this->getView();

        $attribs = [];
        $attribs['class'] = 'zui-gadget';
        $attribs['data-update-url'] = $view->url($this->options['update_url'], [
            'id' => $gadget->getId(),
        ]);
        $attribs['data-zource-gadget-type'] = $gadget->getGadgetType();
        $attribs['data-zource-gadget-id'] = $gadget->getId();

        return sprintf('<div %s></div>', $this->renderAttribs($attribs));
    }

    private function renderAttribs(array $attribs)
    {
        $result = '';
        foreach ($attribs as $name => $value) {
            $result .= sprintf(' %s="%s"', $name, $this->getView()->escapeHtmlAttr($value));
        }
        return $result;
    }
}
