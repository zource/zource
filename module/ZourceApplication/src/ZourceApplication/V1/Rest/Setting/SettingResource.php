<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\V1\Rest\Setting;

use Zend\Paginator\Adapter\ArrayAdapter;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\Rest\AbstractResourceListener;
use ZourceApplication\TaskService\SettingsManager;

class SettingResource extends AbstractResourceListener
{
    /**
     * @var SettingsManager
     */
    private $settingManager;

    /**
     * Initializes a new instance of this class.
     *
     * @param SettingsManager $settingManager
     */
    public function __construct(SettingsManager $settingManager)
    {
        $this->settingManager = $settingManager;
    }

    public function fetch($id)
    {
        $setting = $this->settingManager->get($id, null);

        if (!$setting) {
            return null;
        }

        return new SettingEntity($id, $setting);
    }

    public function fetchAll($params = array())
    {
        $adapter = new ArrayAdapter($this->settingManager->getAll());

        return new SettingCollection($adapter);
    }

    public function update($id, $data)
    {
        if (!$this->settingManager->has($id)) {
            return new ApiProblem(ApiProblemResponse::STATUS_CODE_404, 'The setting does not exists.');
        }

        $this->settingManager->set($id, $data->value);
        $this->settingManager->flush();

        return new SettingEntity($id, $data->value);
    }
}
