<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\V1\Rest\Setting;

use ZourceApplication\TaskService\SettingsManager;

class SettingResourceFactory
{
    public function __invoke($services)
    {
        $settingManager = $services->get(SettingsManager::class);

        return new SettingResource($settingManager);
    }
}
