<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\V1\Rest\Plugin;

use Zend\Paginator\Adapter\ArrayAdapter;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\Hal\Entity as HalEntity;
use ZF\Hal\Link\Link;
use ZF\Rest\AbstractResourceListener;
use ZourceApplication\TaskService\PluginManager;

class PluginResource extends AbstractResourceListener
{
    /**
     * @var PluginManager
     */
    private $pluginManager;

    /**
     * Initializes a new instance of this class.
     *
     * @param array $config
     */
    public function __construct(PluginManager $pluginManager)
    {
        $this->pluginManager = $pluginManager;
    }

    public function delete($id)
    {
        $plugin = $this->pluginManager->getPlugin($id);
        if (!$plugin) {
            return new ApiProblem(ApiProblemResponse::STATUS_CODE_404, 'Entity not found.');
        }

        $this->pluginManager->uninstall($plugin);

        return true;
    }

    public function fetch($id)
    {
        $plugin = $this->pluginManager->getPlugin($id);
        if (!$plugin) {
            return null;
        }

        return $this->buildEntity($plugin);
    }

    public function fetchAll($params = array())
    {
        $adapter = new ArrayAdapter($this->pluginManager->getPlugins());

        return new PluginCollection($adapter);
    }

    private function buildEntity($plugin)
    {
        $entity = new HalEntity(new PluginEntity($plugin), $plugin->getId());
        $entity->getLinks()->add(Link::factory([
            'rel' => 'activate',
            'route' => [
                'name' => 'zource-application.rest.plugin',
                'params' => [
                    'plugin_id' => $plugin->getId(),
                ],
            ],
        ]));
        $entity->getLinks()->add(Link::factory([
            'rel' => 'deactivate',
            'route' => [
                'name' => 'zource-application.rest.plugin',
                'params' => [
                    'plugin_id' => $plugin->getId(),
                ],
            ],
        ]));

        return $entity;
    }
}
