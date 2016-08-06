<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\V1\Rest\Gadget;

use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\Hal\Entity as HalEntity;
use ZF\Hal\Link\Link;
use ZF\Rest\AbstractResourceListener;
use ZourceApplication\TaskService\Gadget;

class GadgetResource extends AbstractResourceListener
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

    public function delete($id)
    {
        /** @var \ZourceApplication\Entity\Gadget $gadget */
        $gadget = $this->gadgetTaskService->find($id);
        if (!$gadget) {
            return new ApiProblem(ApiProblemResponse::STATUS_CODE_404, 'Entity not found.');
        }

        $this->gadgetTaskService->remove($gadget);

        return true;
    }

    public function fetch($id)
    {
        /** @var \ZourceApplication\Entity\Gadget $gadget */
        $gadget = $this->gadgetTaskService->find($id);
        if (!$gadget) {
            return null;
        }

        return $this->buildGadgetEntity($gadget);
    }

    public function fetchAll($params = array())
    {
        $adapter = $this->gadgetTaskService->getPaginator()->getAdapter();

        return new GadgetCollection($adapter);
    }

    public function patch($id, $data)
    {
        /** @var \ZourceApplication\Entity\Gadget $gadget */
        $gadget = $this->gadgetTaskService->find($id);
        if (!$gadget) {
            return new ApiProblem(ApiProblemResponse::STATUS_CODE_404, 'Entity not found.');
        }
        
        $this->gadgetTaskService->updateFromArray($gadget, (array)$data);

        return $this->buildGadgetEntity($gadget);
    }

    public function update($id, $data)
    {
        /** @var \ZourceApplication\Entity\Gadget $gadget */
        $gadget = $this->gadgetTaskService->find($id);
        if (!$gadget) {
            return new ApiProblem(ApiProblemResponse::STATUS_CODE_404, 'Entity not found.');
        }

        $this->gadgetTaskService->updateFromArray($gadget, (array)$data);

        return $this->buildGadgetEntity($gadget);
    }

    private function buildGadgetEntity($gadget)
    {
        $entity = new HalEntity(new GadgetEntity($gadget), $gadget->getId());
        $entity->getLinks()->add(Link::factory([
            'rel' => 'gadget-container',
            'route' => [
                'name' => 'zource-application.rest.gadget-container',
                'params' => [
                    'gadget_container_id' => $gadget->getGadgetContainer()->getId(),
                ],
            ],
        ]));

        return $entity;
    }
}
