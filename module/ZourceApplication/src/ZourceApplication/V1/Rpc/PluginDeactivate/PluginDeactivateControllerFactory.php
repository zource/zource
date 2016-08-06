<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\V1\Rpc\PluginDeactivate;

use ZourceApplication\TaskService\PluginManager;

class PluginDeactivateControllerFactory
{
    public function __invoke($controllers)
    {
        $pluginManager = $controllers->getServiceLocator()->get(PluginManager::class);

        return new PluginDeactivateController($pluginManager);
    }
}
