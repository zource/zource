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
use ZourceApplication\TaskService\SettingsManager;

class Settings extends AbstractHelper
{
    /**
     * @var SettingsManager
     */
    private $settingsManager;

    public function __construct(SettingsManager $settingsManager)
    {
        $this->settingsManager = $settingsManager;
    }

    public function __invoke($name, $defaultValue = null)
    {
        return $this->settingsManager->get($name, $defaultValue);
    }
}
