<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\V1\Rest\GadgetContainer;

use ZourceApplication\TaskService\Gadget;

class GadgetContainerResourceFactory
{
    public function __invoke($services)
    {
        $gadgetTaskService = $services->get(Gadget::class);

        return new GadgetContainerResource($gadgetTaskService);
    }
}
