<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceContact\View\Helper;

use Ramsey\Uuid\UuidInterface;
use Zend\Form\Element;
use Zend\View\Helper\AbstractHelper;
use ZourceContact\Entity\AbstractContact;
use ZourceContact\ValueObject\ContactEntry;

class ContactAvatar extends AbstractHelper
{
    public function __invoke(AbstractContact $contact = null)
    {
        if (!$contact) {
            return $this;
        }

        return $this->render($contact);
    }

    public function render(AbstractContact $contact)
    {
        $src = $this->getUrl($contact);
        $alt = $contact->getDisplayName();

        return sprintf(
            '<img src="%s" alt="%s" />',
            $this->getView()->escapeHtmlAttr($src),
            $this->getView()->escapeHtmlAttr($alt)
        );
    }

    public function getUrl(AbstractContact $contact)
    {
        if ($contact->getAvatar()) {
            $src = 'img/avatars/' . $contact->getAvatar() . '.png';
        } else {
            $src = 'img/avatars/' . $contact->getId()->toString() . '.png';
        }

        if (!is_file('public/' . $src)) {
            $src = 'img/avatars/default.png';
        }

        return $this->getView()->basePath($src);
    }
}
