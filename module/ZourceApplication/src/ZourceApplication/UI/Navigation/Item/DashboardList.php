<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\UI\Navigation\Item;

use Zend\View\Renderer\RendererInterface;
use ZourceApplication\TaskService\Dashboard;
use ZourceUser\Entity\AccountInterface;

class DashboardList extends Label
{
    use LabelTrait;
    use UrlTrait;

    private $dashboardTaskService;

    public function __construct(RendererInterface $view, Dashboard $dashboardTaskService)
    {
        parent::__construct($view);

        $this->dashboardTaskService = $dashboardTaskService;
    }

    public function render(array $item)
    {
        /** @var AccountInterface $account */
        $account = $this->getView()->zourceAccount();

        if (!$account) {
            return '<span><em>None</em></span>';
        }

        // TODO: Introduce a system where dashboards can be shared with accounts and groups. In this menu we can show
        // all dashboards that are shared with the account.

        $dashboards = $this->dashboardTaskService->findAll();

        $result = '<ul class="zui-nav">';

        foreach ($dashboards as $dashboard) {
            $result .= '<li role="presentation" class="">';
            $result .= sprintf(
                '<a href="%s" title="%s">%s</a>',
                $this->getView()->url('dashboard/select', [
                    'id' => $dashboard->getId(),
                ]),
                $dashboard->getName(),
                $dashboard->getName()
            );
            $result .= '</li>';
        }
        $result .= '</ul>';

        return $result;
    }
}
