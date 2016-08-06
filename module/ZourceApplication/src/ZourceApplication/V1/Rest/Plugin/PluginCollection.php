<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\V1\Rest\Plugin;

use ZF\Hal\Entity as HalEntity;
use ZF\Hal\Link\Link;
use ZourceApplication\Paginator\AbstractProxy;

class PluginCollection extends AbstractProxy
{
    protected function build($key, $value)
    {
        return $this->buildEntity($value);
    }

    private function buildEntity($plugin)
    {
        $entity = new HalEntity(new PluginEntity($plugin), $plugin->getId());
        $entity->getLinks()->add(Link::factory([
            'rel' => 'self',
            'route' => [
                'name' => 'zource-application.rest.plugin',
                'params' => [
                    'plugin_id' => $plugin->getId(),
                ],
            ],
        ]));
        $entity->getLinks()->add(Link::factory([
            'rel' => 'activate',
            'route' => [
                'name' => 'zource-application.rpc.plugin-activate',
                'params' => [
                    'plugin_id' => $plugin->getId(),
                ],
            ],
        ]));
        $entity->getLinks()->add(Link::factory([
            'rel' => 'deactivate',
            'route' => [
                'name' => 'zource-application.rpc.plugin-deactivate',
                'params' => [
                    'plugin_id' => $plugin->getId(),
                ],
            ],
        ]));

        return $entity;
    }
}
