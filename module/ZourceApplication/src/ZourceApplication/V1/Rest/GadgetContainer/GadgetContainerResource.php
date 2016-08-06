<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\V1\Rest\GadgetContainer;

use ZF\Rest\AbstractResourceListener;
use ZourceApplication\TaskService\Gadget;

class GadgetContainerResource extends AbstractResourceListener
{
    /**
     * @var Gadget
     */
    private $gadgetTaskService;

    /**
     * Initializes a new instance of this class.
     *
     * @param Gadget $gadgetTaskService
     */
    public function __construct(Gadget $gadgetTaskService)
    {
        $this->gadgetTaskService = $gadgetTaskService;
    }

    public function fetch($id)
    {
        $gadgetContainer = $this->gadgetTaskService->findContainer($id);
        if (!$gadgetContainer) {
            return null;
        }

        return new GadgetContainerEntity($gadgetContainer);
    }

    public function fetchAll($params = array())
    {
        $adapter = $this->gadgetTaskService->getContainerPaginator()->getAdapter();

        return new GadgetContainerCollection($adapter);
    }
}
