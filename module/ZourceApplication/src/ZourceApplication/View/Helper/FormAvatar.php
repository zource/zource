<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\View\Helper;

use Zend\Form\Element;
use Zend\View\Helper\AbstractHelper;

class FormAvatar extends AbstractHelper implements AdditionalRenderer
{
    public function __invoke(Element $element)
    {
        $view = $this->getView();
        $default = $view->escapeHtmlAttr($view->basePath('img/avatars/placeholder.png'));

        $id = uniqid('dialog-', false);
        $element->setOption('dialog_id', $id);

        $name = $view->escapeHtmlAttr($element->getName());

        $html = <<<EOT
<div class="zource-avatar-selection zui-file-selection-trigger-container" data-zui-file-selection-trigger="#file-selection-$id">
    <input type="hidden" name="$name" value="placeholder">

    <p>
        <img src="$default" alt="Avatar" tabindex="1" class="zui-file-selection-trigger-thumb">
    </p>
</div>
EOT;

        return $html;
    }

    public function renderAdditional(array $data)
    {
        $view = $this->getView();
        $element = $data['element'];

        $id = $element->getOption('dialog_id');
        $title = $view->translate('formSelectAvatarDialogTitle');
        $description = $view->translate('formSelectAvatarDialogDescription');
        $buttonCancel = $view->translate('formSelectAvatarDialogButtonCancel');

        $html = <<<EOT
<div class="zui-file-selection zui-dialog zui-dialog-small" id="file-selection-$id">
    <div class="zui-dialog-header">
        <h2>$title</h2>
        <i class="zui-icon zui-icon-x"></i>
    </div>

    <div class="zui-dialog-page">
        <div class="zui-dialog-page-body">
            <div class="zui-dialog-panel zui-dialog-panel-no-padding">
                <ul class="zui-file-selection-items">
EOT;

        for ($i = 0; $i < 10; ++$i) {
            $html .= $this->renderListItem($i);
        }

        $html .= <<<EOT
                </ul>
            </div>
        </div>
    </div>

    <div class="zui-dialog-footer">
        <div class="zui-dialog-footer-left">
            <div class="zui-dialog-hint">
                $description
            </div>
        </div>

        <div class="zui-dialog-footer-right">
            <a href="#" data-zui-dialog-button="cancel">$buttonCancel</a>
        </div>
    </div>
</div>
EOT;

        return $html;
    }

    private function renderListItem($i)
    {
        $view = $this->getView();
        $selectFile = $view->escapeHtmlAttr($view->translate('formSelectAvatarDialogSelectFile'));
        $id = $i;
        $path = $view->escapeHtmlAttr($view->basePath('img/avatars/placeholder.png'));
        $thumbnail = $path;


        $html = <<<EOT
                    <li title="$selectFile">
                        <button tabindex="1" data-zui-file-selection-id="placeholder" data-zui-file-selection-preview="$path">
                            <img src="$thumbnail" alt="$selectFile">
                        </button>
                    </li>

EOT;
        return $html;
    }
}
