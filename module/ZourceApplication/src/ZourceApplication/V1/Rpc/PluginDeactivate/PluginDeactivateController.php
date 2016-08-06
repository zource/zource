<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\V1\Rpc\PluginDeactivate;

use Zend\Mvc\Controller\AbstractActionController;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
use ZourceApplication\TaskService\PluginManager;

class PluginDeactivateController extends AbstractActionController
{
    private $pluginManager;

    public function __construct(PluginManager $pluginManager)
    {
        $this->pluginManager = $pluginManager;
    }

    public function pluginDeactivateAction()
    {
        $plugin = $this->pluginManager->getPlugin($this->params('plugin_id'));

        if (!$plugin) {
            return new ApiProblemResponse(new ApiProblem(ApiProblemResponse::STATUS_CODE_404, 'Entity not found.'));
        }

        $this->pluginManager->deactivatePlugin($plugin);

        return $this->getResponse();
    }
}
