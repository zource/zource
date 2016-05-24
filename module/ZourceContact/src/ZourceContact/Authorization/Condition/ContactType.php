<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceContact\Authorization\Condition;

use RuntimeException;
use Zend\View\Renderer\PhpRenderer;
use ZourceApplication\Authorization\Condition\AbstractCondition;
use ZourceContact\ValueObject\ContactEntry;

/**
 * A condition that checks if a the contact on the active page is of a given type.
 */
class ContactType extends AbstractCondition
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var PhpRenderer
     */
    private $renderer;

    public function __construct($options, PhpRenderer $renderer)
    {
        if (!isset($options['type'])) {
            throw new RuntimeException('Missing the "type" option.');
        }

        $this->type = $options['type'];
        $this->renderer = $renderer;
    }

    public function isValid()
    {
        return $this->getContactType() === $this->type;
    }

    private function getContactType()
    {
        $viewModel = $this->renderer->viewModel()->getCurrent();
        $viewModelChildren = $viewModel->getChildren();
        $pageModel = $viewModelChildren[0];

        $company = $pageModel->getVariable('company');
        if ($company !== null) {
            return ContactEntry::TYPE_COMPANY;
        }

        $person = $pageModel->getVariable('person');
        if ($person !== null) {
            return ContactEntry::TYPE_PERSON;
        }

        return ContactEntry::TYPE_UNKNOWN;
    }
}
