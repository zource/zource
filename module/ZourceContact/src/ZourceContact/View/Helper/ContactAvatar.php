<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceContact\View\Helper;

use Zend\View\Helper\AbstractHelper;
use ZourceContact\ValueObject\ContactEntry;

class ContactAvatar extends AbstractHelper
{
    public function __invoke(ContactEntry $contact)
    {
        $src = $this->getView()->basePath('/img/avatars/' . $contact->getId()->toString());
        $alt = $contact->getDisplayName();

        return sprintf(
            '<img src="%s" alt="%s" />',
            $this->getView()->escapeHtmlAttr($src),
            $this->getView()->escapeHtmlAttr($alt)
        );
    }
}
