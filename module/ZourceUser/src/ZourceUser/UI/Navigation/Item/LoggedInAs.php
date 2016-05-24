<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\UI\Navigation\Item;

use RuntimeException;
use Zend\View\Renderer\RendererInterface;
use ZourceApplication\UI\Navigation\Item\Label;
use ZourceUser\Authentication\AuthenticationService;
use ZourceUser\Entity\AccountInterface;

class LoggedInAs extends Label
{
    private $authenticationService;

    public function __construct(RendererInterface $view, AuthenticationService $authenticationService)
    {
        parent::__construct($view);

        $this->authenticationService = $authenticationService;
    }

    public function render(array $item)
    {
        /** @var AccountInterface $account */
        $account = $this->authenticationService->getAccountEntity();

        if (!$account) {
            throw new RuntimeException('No account available.');
        }
        
        $listAttr = [];
        $listAttr['role'] = 'presentation';

        $url = $this->getView()->url('contacts/view', [
            'type' => 'person',
            'id' => $account->getContact()->getId()->toString(),
        ]);

        return sprintf(
            '<li %s><a href="%s">%s</a></li>',
            $this->createAttribs($listAttr),
            $url,
            $account->getContact()->getFullName()
        );
    }
}
