<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\V1\Rest\GadgetContainer;

use ZF\Hal\Collection;
use ZourceApplication\Entity\GadgetContainer;
use ZourceApplication\V1\Rest\Gadget\GadgetEntity;

class GadgetContainerEntity
{
    public $id;
    public $layout;
    public $gadgets;

    public function __construct(GadgetContainer $item)
    {
        $this->id = $item->getId();
        $this->layout = $item->getLayout();
        $this->gadgets = $this->extractGadgets($item);
    }

    private function extractGadgets(GadgetContainer $item)
    {
        $result = [];

        foreach ($item->getGadgets() as $gadget) {
            $result[] = new GadgetEntity($gadget);
        }

        return new Collection($result);
    }
}
