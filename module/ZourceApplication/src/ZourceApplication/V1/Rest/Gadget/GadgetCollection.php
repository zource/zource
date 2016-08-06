<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\V1\Rest\Gadget;

use ZF\Hal\Entity as HalEntity;
use ZF\Hal\Link\Link;
use ZourceApplication\Paginator\AbstractProxy;

class GadgetCollection extends AbstractProxy
{
    protected function build($key, $value)
    {
        $entity = new HalEntity(new GadgetEntity($value), $value->getId());
        $entity->getLinks()->add(Link::factory([
            'rel' => 'self',
            'route' => [
                'name' => 'zource-application.rest.gadget',
                'params' => [
                    'gadget_id' => $value->getId(),
                ],
            ],
        ]));
        $entity->getLinks()->add(Link::factory([
            'rel' => 'gadget-container',
            'route' => [
                'name' => 'zource-application.rest.gadget-container',
                'params' => [
                    'gadget_container_id' => $value->getGadgetContainer()->getId(),
                ],
            ],
        ]));

        return $entity;
    }
}
